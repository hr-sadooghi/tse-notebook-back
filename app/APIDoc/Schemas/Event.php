<?php


namespace App\APIDoc\Schemas;

use OpenApi\Annotations AS OA;


/**
 * @OA\Schema(schema="Event", type="object", description="Data structure to create new event.")
 */
class Event
{
    /**
     * @OA\Property(description="type", type="enum", enum={"text", "image", "file", "link", "trade"}, example="text"),
     * @var string
     */
    public $type;

    /**
     * @OA\Property(type="integer", description="This is detail_id", example=""),
     * @var integer
     */
    public $detail_id;

    /**
     * @OA\Property(type="string", description="This is description", example="this is good share that I bought."),
     */
    public $description;

    /**
     * @OA\Property(type="date", description="This is date", example="2019-3-7"),
     * @var string
     */
    public $date;

    /**
     * @OA\Property(type="integer", description="This is company_id", example="1"),
     * @var string
     */
    public $company_id;
}
