<?php


namespace App\Service;


class Helper
{

    public function insertItemIntoSequence($list, $seqNumber, $item)
    {
        if (key_exists($seqNumber, $list)) {
            return $this->insertItemIntoSequence($list, $seqNumber +1, $item );
        } else {
            $list[$seqNumber] = $item;
            return $list;
        }
    }
}
