<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\{Book,Category};

class BookCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */


    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($page) {
                return [
                    'id' => $page->id,
                    'title' => $page->title,
                    'pengarang' => $page->pengarang,
                    'penerbit' => $page->penerbit,
                    'category_id' => $page->category_id,
                    'category' => Category::where('id', $page->category_id)->first()->name,
                    'thumb' => !is_null($page->thumb) ? env('APP_URL').'/thumb/'.$page->thumb : NULL,
                ];
            }),
        ];
    }
}
