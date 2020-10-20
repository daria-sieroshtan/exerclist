<?php

namespace App;

use App\Entity\ItemOfSequenceInterface;

class Helper
{
    /**
     * @param ItemOfSequenceInterface $a
     * @param ItemOfSequenceInterface $b
     * @return int -1|0|1
     */
    public static function compareItemsBySeqNumber(ItemOfSequenceInterface $a, ItemOfSequenceInterface $b)
    {
        if ($a->getSequentialNumber() == $b->getSequentialNumber()) {
            return 0;
        }
        return ($a->getSequentialNumber() < $b->getSequentialNumber()) ? -1 : 1;
    }
}
