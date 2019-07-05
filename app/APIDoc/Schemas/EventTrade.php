<?php


namespace App\APIDoc\Schemas;

use OpenApi\Annotations AS OA;


/**
 * @OA\Schema(schema="EventTrade", type="object", description="Data structure to create new trade event.")
 */
class EventTrade
{
    /**
     * @OA\Property(type="integer", description="each unit price in rial", example="237")
     * @var integer
     */
    public $unit_price;

    /**
     * @OA\Property(type="integer", description="number of units", example="10000")
     * @var integer
     */
    public $units;

    /**
     * @OA\Property(description="type", type="enum", enum={"sell", "buy"}, example="buy"),
     * @var string
     */
    public $type;

    /**
     * @OA\Property(type="integer", description="This is wage", example="0"),
     * @var integer
     */
    public $wage;

    /**
     * @OA\Property(type="integer", description="This is total_amount", example="2370000"),
     * @var integer
     */
    public $total_amount;

    /**
     * @OA\Property(type="enum", description="This is status", enum={"done", "half", "going"}, example="done"),
     * @var string
     */
    public $status;

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
