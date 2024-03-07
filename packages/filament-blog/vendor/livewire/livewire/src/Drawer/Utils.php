<?php

namespace Livewire\Drawer;

use Illuminate\Http\Request;
use Livewire\Exceptions\RootTagMissingFromViewException;
use Livewire\Features\SupportFileUploads\FileUploadConfiguration;

use function Livewire\invade;

class Utils extends BaseUtils
{
    public static function insertAttributesIntoHtmlRoot($html, $attributes)
    {
        $attributesFormattedForHtmlElement = static::stringifyHtmlAttributes($attributes);

        preg_match('/(?:\n\s*|^\s*)<([a-zA-Z0-9\-]+)/', $html, $matches, PREG_OFFSET_CAPTURE);

        throw_unless(
            count($matches),
            new RootTagMissingFromViewException
        );

        $tagName = $matches[1][0];
        $lengthOfTagName = strlen($tagName);
        $positionOfFirstCharacterInTagName = $matches[1][1];

        return substr_replace(
            $html,
            ' '.$attributesFormattedForHtmlElement,
            $positionOfFirstCharacterInTagName + $lengthOfTagName,
            0
        );
    }

    public static function stringifyHtmlAttributes($attributes)
    {
        return collect($attributes)
            ->mapWithKeys(function ($value, $key) {
                return [$key => static::escapeStringForHtml($value)];
            })->map(function ($value, $key) {
                return sprintf('%s="%s"', $key, $value);
            })->implode(' ');
    }

    public static function escapeStringForHtml($subject)
    {
        if (is_string($subject) || is_numeric($subject)) {
            return htmlspecialchars($subject, ENT_QUOTES | ENT_SUBSTITUTE);
        }

        return htmlspecialchars(json_encode($subject), ENT_QUOTES | ENT_SUBSTITUTE);
    }

    public static function pretendResponseIsFile($file, $contentType = 'application/javascript; charset=utf-8')
    {
        $lastModified = filemtime($file);

        return static::cachedFileResponse($file, $contentType, $lastModified,
            fn ($headers) => response()->file($file, $headers));
    }

    public static function pretendPreviewResponseIsPreviewFile($filename)
    {
        $file = FileUploadConfiguration::path($filename);
        $storage = FileUploadConfiguration::storage();
        $mimeType = FileUploadConfiguration::mimeType($filename);
        $lastModified = FileUploadConfiguration::lastModified($file);

        return self::cachedFileResponse($filename, $mimeType, $lastModified,
            fn ($headers) => $storage->download($file, $filename, $headers));
    }

    private static function cachedFileResponse($filename, $contentType, $lastModified, $downloadCallback)
    {
        $expires = strtotime('+1 year');
        $cacheControl = 'public, max-age=31536000';

        if (static::matchesCache($lastModified)) {
            return response('', 304, [
                'Expires' => static::httpDate($expires),
                'Cache-Control' => $cacheControl,
            ]);
        }

        $headers = [
            'Content-Type' => $contentType,
            'Expires' => static::httpDate($expires),
            'Cache-Control' => $cacheControl,
            'Last-Modified' => static::httpDate($lastModified),
        ];

        if (str($filename)->endsWith('.br')) {
            $headers['Content-Encoding'] = 'br';
        }

        return $downloadCallback($headers);
    }

    public static function matchesCache($lastModified)
    {
        $ifModifiedSince = app(Request::class)->header('if-modified-since');

        return $ifModifiedSince !== null && @strtotime($ifModifiedSince) === $lastModified;
    }

    public static function httpDate($timestamp)
    {
        return sprintf('%s GMT', gmdate('D, d M Y H:i:s', $timestamp));
    }

    public static function containsDots($subject)
    {
        return str_contains($subject, '.');
    }

    public static function dotSegments($subject)
    {
        return explode('.', $subject);
    }

    public static function beforeFirstDot($subject)
    {
        return head(explode('.', $subject));
    }

    public static function afterFirstDot($subject): string
    {
        return str($subject)->after('.');
    }

    public static function hasProperty($target, $property)
    {
        return property_exists($target, static::beforeFirstDot($property));
    }

    public static function shareWithViews($name, $value)
    {
        $old = app('view')->shared($name, 'notfound');

        app('view')->share($name, $value);

        return $revert = function () use ($name, $old) {
            if ($old === 'notfound') {
                unset(invade(app('view'))->shared[$name]);
            } else {
                app('view')->share($name, $old);
            }
        };
    }

    public static function generateBladeView($subject, $data = [])
    {
        if (! is_string($subject)) {
            return tap($subject)->with($data);
        }

        $component = new class($subject) extends \Illuminate\View\Component
        {
            protected $template;

            public function __construct($template)
            {
                $this->template = $template;
            }

            public function render()
            {
                return $this->template;
            }
        };

        $view = app('view')->make($component->resolveView(), $data);

        return $view;
    }

    public static function applyMiddleware(\Illuminate\Http\Request $request, $middleware = [])
    {
        return (new \Illuminate\Pipeline\Pipeline(app()))
            ->send($request)
            ->through($middleware)
            ->then(function () {
                return new \Illuminate\Http\Response();
            });
    }

    public static function extractAttributeDataFromHtml($html, $attribute)
    {
        $data = (string) str($html)->betweenFirst($attribute.'="', '"');

        return json_decode(
            htmlspecialchars_decode($data, ENT_QUOTES | ENT_SUBSTITUTE),
            associative: true,
        );
    }
}
