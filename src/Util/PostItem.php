<?php


namespace App\Util;


class PostItem
{
    private $description;
    private $lengthMeters;

    public function isDeliveryToPerson()
    {
        return $this->lengthMeters > 0.3;
    }

    public function isDeliveryToPersonString()
    {
        if($this->isDeliveryToPerson())
            return 'hand to recipient';

        return 'post through letterbox';
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getLengthMeters()
    {
        return $this->lengthMeters;
    }

    /**
     * @param mixed $lengthMeters
     */
    public function setLengthMeters($lengthMeters): void
    {
        $this->lengthMeters = $lengthMeters;
    }



}