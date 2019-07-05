<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * @OA\Get(
     *     path="/links/meta-tag-extractor",
     *     summary="Get title and description of specified URL",
     *     @OA\Parameter(
     *          name="url",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="string", format="string", example="http://www.google.com")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Get meta tag information for specified url.",
     *          @OA\JsonContent()
     *     )
     * )
     */
    public function apiGetMetaTagExtractor(Request $request)
    {
        $url = $request->get('url');
        $result = [];
        function file_get_contents_curl($url)
        {
            $ch = curl_init();
            $timeout = 10;

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 3000);
            curl_setopt($ch, CURLOPT_ENCODING, "gzip");
            curl_setopt($ch, CURLOPT_HEADER, 0);

            $data = curl_exec($ch);

            curl_close($ch);

            return $data;
        }

        $html = file_get_contents_curl($url);

        $doc = new \DOMDocument();
        @$doc->loadHTML($html);

        $nodes = $doc->getElementsByTagName('title');

        if ($nodes->count()) {
            $result['title'] = $nodes->item(0)->nodeValue;
        }


        $metas = $doc->getElementsByTagName('meta');

        for ($i = 0; $i < $metas->length; $i++) {
            $meta = $metas->item($i);
            if ($meta->getAttribute('name') == 'description') {
                $result['description'] = $meta->getAttribute('content');
            }

            if (substr($meta->getAttribute('property'), 0, 3) === 'og:') {
                $result[$meta->getAttribute('property')] = $meta->getAttribute('content');
            }
        }
        return $result;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Link $link
     * @return \Illuminate\Http\Response
     */
    public function show(Link $link)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Link $link
     * @return \Illuminate\Http\Response
     */
    public function edit(Link $link)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Link $link
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Link $link)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Link $link
     * @return \Illuminate\Http\Response
     */
    public function destroy(Link $link)
    {
        //
    }
}
