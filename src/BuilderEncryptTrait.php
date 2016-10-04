<?php

namespace VeryBuy\Payment\EsunBank\Acq\CardLink;

trait BuilderEncryptTrait
{
    /**
     * @param string $data
     *
     * @return string
     */
    public function encrypt($data)
    {
//        dump(sprintf('ENCRYPT_STRING:%s', $data.static::getHashKey()));
//
//        $encrypted = hash('sha256', '{"TxnType":"A","Account":"testacct"}123456789ABCDEF123456789ABCDEF');
//        
//        dump([
//            'stringt' => $encrypted,
//            'verify' => ($encrypted == '6125537529184f83096449d5e04a68732a72ce434e580940dccd73d2ced3d389')
//        ]);

        return hash('sha256', $data.static::getHashKey());
    }
}
