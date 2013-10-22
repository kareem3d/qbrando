<?php

use Illuminate\Database\Query\Builder;
use Kareem3d\Ecommerce\Category;
use Kareem3d\Eloquent\Model;

class ProductAlgorithm extends \Kareem3d\Eloquent\Algorithm {

    /**
     * @return $this
     */
    public function specials()
    {
        $this->getQuery()->where('offer_price', '!=', 'NULL')->orderBy(DB::raw('RAND()'));

        return $this;
    }

    /**
     * @param $low
     * @param $high
     * @return $this
     */
    public function priceBetween( $low, $high )
    {
        $this->getQuery()->where(function( Builder $query ) use($low, $high) {

            // First we check for the offer price to see if it's set and between the given range
            $query->where('offer_price', '!=', null)->where('offer_price', '>=', $low)->where('offer_price', '<=', $high);

        })->orWhere(function(Builder $query) use($low, $high) {

            // If Offer price wasn't set then get the price between the given range
            $query->where('price', '>=', $low)->where('price', '<=', $high);

        });

        return $this;
    }

    /**
     * @param $gender
     * @return $this
     */
    public function byGender( $gender )
    {
        $gender = strtolower($gender);

        // If it's unisex then just do nothing
        if($gender != 'unisex')
        {
            // Get either the given gender or unisex models...
            $this->getQuery()->where(function( $query ) use ($gender)
            {
                $query->where('gender', $gender)->orWhere('gender', 'unisex');
            });
        }

        return $this;
    }

    /**
     * @param $id
     * @return $this
     */
    public function byColor( $id )
    {
        $id = $this->getId( $id );

        $this->getQuery()->where('color_id', $id);

        return $this;
    }

    /**
     * @param $id
     * @return $this
     */
    public function byCategory( $id )
    {
        $id = $this->getId( $id );

        $this->getQuery()->where('category_id', $id);

        return $this;
    }

    /**
     * @param $id
     * @return mixed
     */
    protected  function getId( $id )
    {
        return $id instanceof Model ? $id->getKey() : $id;
    }

    /**
     * @return Builder
     */
    public function emptyQuery()
    {
        return Product::query();
    }
}