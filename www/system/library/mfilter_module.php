<?php
//

class MegaFilterModule
{
    private $a6SedsPYaGpr6a;
    private static $a7cZdUxdEnYI7a = false;
    private function a0llvKGJqpeM0a($ct3b1)
    {
        goto uP1kZ;
        uP1kZ:
        $WASo5 = array();
        goto p_Qga;
        si42P:
        return $WASo5;
        goto WhG1Y;
        p_Qga:
        foreach ($ct3b1 as $x3irE => $KzhQF) {
            $WASo5[$KzhQF["\163\145\x6f\137\156\x61\155\x65"]] = $x3irE;
            yJ4TG:
        }
        goto KDz9S;
        KDz9S:
        jcYAf:
        goto si42P;
        WhG1Y:
    }
    private function a1vgzPkKNSXA1a($Z7cD6, $CYbjs)
    {
        goto czKWS;
        o3GNq:
        return false;
        goto dY4Pj;
        jmesZ:
        return true;
        goto GQ7T3;
        czKWS:
        if (!(!is_dir(DIR_SYSTEM . "\x63\x61\143\150\x65\137\155\x66\x70") || !is_writable(DIR_SYSTEM . "\x63\141\143\x68\145\137\x6d\146\x70"))) {
            goto tZ39K;
        }
        goto o3GNq;
        yTlTK:
        $Z7cD6 .= "\56" . $this->config->get("\143\157\x6e\146\151\147\137\x6c\x61\156\x67\165\x61\x67\145\x5f\151\144");
        goto tUxKH;
        tUxKH:
        file_put_contents(DIR_SYSTEM . "\143\141\x63\x68\145\x5f\155\146\160\57" . $Z7cD6, serialize($CYbjs));
        goto kiIZ6;
        dY4Pj:
        tZ39K:
        goto yTlTK;
        kiIZ6:
        file_put_contents(DIR_SYSTEM . "\x63\x61\x63\150\145\137\155\146\160\57" . $Z7cD6 . "\56\x74\x69\155\145", time() + 60 * 60 * 24);
        goto jmesZ;
        GQ7T3:
    }
    private function a2mZwuGAWhuX2a($Z7cD6)
    {
        goto kAwnL;
        uHXhR:
        if (file_exists($EZ4B5)) {
            goto vtfpG;
        }
        goto M4zJP;
        M4zJP:
        return NULL;
        goto oleU7;
        UKcIZ:
        if (!($JAuse < time())) {
            goto jB2RS;
        }
        goto Us81L;
        Us81L:
        @unlink($XH4pB);
        goto x9rmL;
        FjVqH:
        $XH4pB = $g6JYD . $Z7cD6 . "\x2e" . $this->config->get("\x63\157\156\146\x69\x67\137\x6c\141\156\147\x75\x61\147\x65\x5f\x69\144");
        goto eskI3;
        P144K:
        TRLnH:
        goto uHXhR;
        x9rmL:
        @unlink($EZ4B5);
        goto xqJVi;
        Zp3aK:
        return unserialize(file_get_contents($XH4pB));
        goto UiEyA;
        TPVzU:
        jB2RS:
        goto Zp3aK;
        kAwnL:
        $g6JYD = DIR_SYSTEM . "\x63\x61\x63\x68\145\137\155\x66\x70\57";
        goto FjVqH;
        agO3o:
        return NULL;
        goto P144K;
        X9eKP:
        $JAuse = (double) file_get_contents($EZ4B5);
        goto UKcIZ;
        oleU7:
        vtfpG:
        goto X9eKP;
        eskI3:
        $EZ4B5 = $XH4pB . "\56\x74\x69\x6d\x65";
        goto tEq93;
        xqJVi:
        return false;
        goto TPVzU;
        tEq93:
        if (file_exists($XH4pB)) {
            goto TRLnH;
        }
        goto agO3o;
        UiEyA:
    }
    private function a3wEFbFRtPae3a($LfqRd, $lXdhv = false)
    {
        goto WMiod;
        I2GfT:
        echo "\74\x62\162\40\x2f\76\74\142\162\40\x2f\76";
        goto OoDq0;
        qBvbR:
        VHOKm:
        goto LWy01;
        WMiod:
        if (!self::$a7cZdUxdEnYI7a) {
            goto Mx3WM;
        }
        goto JjDIH;
        OoDq0:
        echo "\x50\x6c\x65\x61\x73\145\x20\x3c\141\40\x68\x72\x65\146\75\x22\150\164\164\x70\x73\72\57\x2f\147\x69\164\150\x75\142\56\x63\x6f\155\x2f\x76\x71\x6d\x6f\144\57\x76\161\x6d\x6f\144\x2f\x72\x65\x6c\x65\141\163\x65\163\57\164\x61\x67\x2f\x76\62\56\66\56\x31\55\x6f\160\145\x6e\143\141\x72\x74\x22\40\164\x61\162\147\145\164\75\x22\137\142\x6c\141\156\x6b\x22\x3e\x64\157\x77\x6e\154\x6f\x61\144\40\126\x51\115\157\144\x3c\57\x61\x3e\x20\141\x6e\144\x20\x72\x65\141\x64\40";
        goto wvBsT;
        LWy01:
        echo "\74\57\144\x69\166\x3e";
        goto CULkt;
        SwyaX:
        if (!$lXdhv) {
            goto VHOKm;
        }
        goto I2GfT;
        uKngs:
        echo "\x3c\x64\x69\x76\x20\163\164\x79\154\x65\75\42\160\141\x64\144\151\156\147\72\40\61\x30\x70\x78\x3b\x20\x74\x65\170\164\x2d\x61\154\x69\x67\156\72\40\x63\145\x6e\x74\145\x72\42\x3e";
        goto OHkWZ;
        JjDIH:
        return;
        goto Dtnfk;
        Dtnfk:
        Mx3WM:
        goto uKngs;
        wvBsT:
        echo "\74\x61\40\x68\162\x65\146\x3d\42\150\164\x74\160\x73\72\57\x2f\x67\x69\x74\150\x75\x62\56\143\x6f\x6d\57\166\x71\155\157\144\x2f\x76\161\x6d\157\x64\57\167\151\x6b\x69\57\111\156\x73\164\x61\154\154\151\156\x67\55\166\121\x6d\157\144\x2d\157\156\x2d\117\160\145\x6e\x43\x61\162\x74\x22\x20\164\x61\162\147\145\x74\x3d\x22\x5f\x62\154\x61\x6e\153\x22\76\x48\x6f\167\x20\x74\157\x20\x69\x6e\x73\x74\141\x6c\x6c\154\x20\x56\121\115\x6f\144\x3c\x2f\141\x3e";
        goto qBvbR;
        OHkWZ:
        echo $LfqRd;
        goto SwyaX;
        CULkt:
        self::$a7cZdUxdEnYI7a = true;
        goto D6OIN;
        D6OIN:
    }
    private function a4cvHrWPjoNj4a($QLyOn)
    {
        goto SAa4t;
        k4_px:
        $wx0U7 = parse_url($QLyOn);
        goto JCp0s;
        JCp0s:
        return $LFIHJ . "\72\x2f\57" . $yZBPK . $wx0U7["\160\141\164\150"] . (empty($wx0U7["\161\165\x65\x72\171"]) ? '' : "\x3f" . str_replace("\46\141\155\x70\73", "\46", $wx0U7["\x71\165\145\162\171"]));
        goto QqJgw;
        ORbg4:
        $yZBPK = isset($_SERVER["\110\124\x54\120\137\x48\117\x53\124"]) ? $_SERVER["\x48\124\124\x50\137\110\x4f\123\124"] : $_SERVER["\x53\x45\122\126\105\x52\x5f\x4e\101\x4d\x45"];
        goto k4_px;
        SAa4t:
        $LFIHJ = isset($_SERVER["\x48\x54\124\x50\x53"]) && $_SERVER["\x48\124\x54\x50\x53"] == "\157\x6e" ? "\150\x74\x74\160\x73" : "\x68\164\x74\160";
        goto ORbg4;
        QqJgw:
    }
    public static function newInstance(&$DExNG)
    {
        return new self($DExNG);
    }
    private function a5cIyozfqOJK5a($QLyOn, $Qnbdw = null)
    {
        return '1';
    }
    private function __construct(&$DExNG)
    {
        goto kvCN7;
        mIeEL:
        $eKtX8 = false;
        goto KEfVW;
        D98VS:
        SHZky:
        goto mIeEL;
        ZRrOf:
        P70la:
        goto Zd8b3;
        nZc39:
        Cxdle:
        goto yQjkW;
        yQjkW:
        F1yhT:
        goto ZRrOf;
        CJGvb:
        if (!file_exists(DIR_SYSTEM . "\154\151\x62\x72\x61\162\x79\57\155\x66\x69\154\164\x65\x72\137\160\154\x75\163\56\160\150\160")) {
            goto SHZky;
        }
        goto uE1QE;
        q_9xM:
        foreach ($this->db->query("\123\105\x4c\x45\x43\124\40\52\40\106\x52\x4f\x4d\40\140" . DB_PREFIX . "\x73\164\x6f\x72\x65\x60")->rows as $tuW8t) {
            $vfdJd[$tuW8t["\163\x74\157\x72\x65\137\x69\x64"]] = $tuW8t["\x75\162\154"];
            x3B3e:
        }
        goto vB1d9;
        Oem8R:
        $this->db->query("\12\11\x9\x9\11\x9\11\x55\120\104\101\x54\105\x20\12\11\11\11\x9\11\x9\x9\x60" . DB_PREFIX . "\x73\145\164\x74\x69\156\147\140\x20\12\11\x9\x9\11\x9\11\x53\105\124\x20\12\11\x9\11\11\x9\11\x9\140\x76\141\154\x75\x65\140\40\75\x20\x27" . $this->db->escape(version_compare(VERSION, "\62\56\x31\56\x30\56\60", "\x3e\x3d") ? json_encode($QLFHS) : serialize($QLFHS)) . "\47\40\xa\x9\11\11\x9\x9\x9\127\x48\105\x52\x45\x20\12\x9\x9\x9\11\x9\11\x9\x60\x6b\x65\171\x60\x20\75\40\x27\155\x66\x69\154\164\x65\x72\137\154\151\x63\145\156\x73\x65\x27");
        goto sak3a;
        KEfVW:
        foreach ($vfdJd as $xHjlY => $QLyOn) {
            goto U8TFL;
            lr8Rn:
            $cqOSW[] = "\143\154\75\x31";
            goto rXX8i;
            FOX3N:
            LBg7x:
            goto UlR_H;
            YKwHL:
            $cqOSW = array("\x6f\162\x64\145\x72\x5f\151\x64\75" . urlencode($QLFHS["\x6f\162\144\145\x72\x5f\151\144"]), "\x6f\x72\x64\x65\x72\137\x65\155\x61\x69\x6c\x3d" . urlencode($QLFHS["\x65\x6d\x61\151\154"]));
            goto DV0Lv;
            TYpD8:
            $cqOSW[] = "\164\75" . urlencode(isset($mrNOt["\x76\x61\154\165\145"]) ? (string) $mrNOt["\x76\x61\x6c\165\145"] : '');
            goto lr8Rn;
            GpVyh:
            $cqOSW[] = "\x68\x3d" . urlencode($yvIit["\150\x6f\163\164"]);
            goto QdS6r;
            HGk5R:
            $cqOSW[] = "\x6f\75" . urlencode(VERSION);
            goto TYpD8;
            rXX8i:
            foreach ($Z9btJ as $PMXpM => $YBbMX) {
                goto bDB41;
                bDB41:
                $QLyOn = "\x68\x74\x74\160\72\x2f\57\141\x63\164\151\x76\x61\164\x65\56\157\143\144\x65\155\157\56\x65\x75\57\77\145\x3d" . urlencode($PMXpM) . "\46\x76\x3d" . urlencode($YBbMX) . "\x26" . implode("\x26", $cqOSW);
                goto u0urD;
                WGcoB:
                goto nwgTX;
                goto o18Fq;
                EX3y5:
                goto nwgTX;
                goto ZWLa5;
                p1MGs:
                EIpgB:
                goto BWbmF;
                poe0L:
                if ($m1uCi == "\x2d\x31") {
                    goto bM_rh;
                }
                goto zIx5r;
                zIx5r:
                if (!($m1uCi != "\61")) {
                    goto qLedF;
                }
                goto LSdf6;
                LSdf6:
                $m1uCi = unserialize($m1uCi);
                goto MGkO5;
                Yly9I:
                $eKtX8 = true;
                goto EX3y5;
                u0urD:
                if (!(false != ($m1uCi = $this->a5cIyozfqOJK5a($QLyOn)))) {
                    goto z55mz;
                }
                goto poe0L;
                ZWLa5:
                rpM5R:
                goto uuBDh;
                vhVsA:
                bM_rh:
                goto hoRxW;
                uuBDh:
                qLedF:
                goto GvI6F;
                o18Fq:
                q3WC1:
                goto dXkEC;
                hoRxW:
                $eKtX8 = true;
                goto WGcoB;
                MGkO5:
                if (!($m1uCi["\163\164\x61\x74\165\163"] != "\x73\165\x63\143\x65\163\163")) {
                    goto rpM5R;
                }
                goto Yly9I;
                GvI6F:
                goto q3WC1;
                goto vhVsA;
                dXkEC:
                z55mz:
                goto p1MGs;
                BWbmF:
            }
            goto uppo4;
            uppo4:
            nwgTX:
            goto ORESz;
            ORESz:
            krRYF:
            goto FOX3N;
            vwAKs:
            $mrNOt = $this->db->query("\x53\x45\x4c\105\103\124\40\x2a\x20\106\122\x4f\115\40\x60" . DB_PREFIX . "\x73\145\x74\x74\151\156\x67\140\40\127\110\x45\122\x45\40\x60\153\145\171\x60\40\111\x4e\50\x27\x63\x6f\156\146\x69\x67\137\x74\150\145\x6d\x65\47\54\x27\143\x6f\x6e\146\x69\147\137\x74\x65\155\x70\154\x61\x74\145\x27\x29\40\x41\x4e\x44\40\140\143\157\144\145\x60\x3d\x27\143\157\x6e\146\151\x67\47\x20\101\x4e\x44\40\140\163\x74\x6f\x72\x65\137\151\x64\140\x3d" . (int) $xHjlY)->row;
            goto GpVyh;
            QdS6r:
            $cqOSW[] = "\x70\75" . urlencode(isset($yvIit["\160\141\164\150"]) ? $yvIit["\160\141\x74\150"] : "\57");
            goto HGk5R;
            U8TFL:
            $yvIit = parse_url($QLyOn);
            goto YKwHL;
            DV0Lv:
            if (empty($yvIit["\x68\157\x73\x74"])) {
                goto krRYF;
            }
            goto vwAKs;
            UlR_H:
        }
        goto UIHos;
        zI3Dl:
        $this->db->query("\x44\105\114\105\x54\105\40\106\x52\x4f\x4d\40\x60" . DB_PREFIX . "\163\x65\164\x74\151\x6e\147\x60\40\127\x48\105\122\x45\40\x60\x6b\145\171\x60\x20\x3d\40\47\x6d\x66\x69\154\164\145\162\x5f\x6c\x69\x63\145\x6e\163\145\47");
        goto oPSJC;
        UIHos:
        K4P8I:
        goto f0Wgn;
        QEBKD:
        $QLFHS["\x74\x69\155\x65"] = time();
        goto Oem8R;
        q0qV_:
        if (!(time() > $QLFHS["\x74\x69\155\145"] + 60 * 60 * 24 * 7)) {
            goto F1yhT;
        }
        goto UBYTE;
        boQTU:
        file_put_contents(DIR_SYSTEM . "\154\151\142\x72\141\162\x79\57\x6d\x66\151\x6c\164\x65\162\137\x6d\x6f\x64\x75\x6c\x65\56\160\x68\x70", '');
        goto nZc39;
        LOb9b:
        IhHdv:
        goto zI3Dl;
        vB1d9:
        AsuXu:
        goto aYbzx;
        oPSJC:
        file_put_contents(DIR_SYSTEM . "\154\151\x62\x72\x61\x72\x79\x2f\x6d\146\x69\x6c\164\x65\x72\137\x63\157\x72\x65\x2e\160\x68\160", '');
        goto boQTU;
        f0Wgn:
        if ($eKtX8) {
            goto IhHdv;
        }
        goto QEBKD;
        uE1QE:
        $Z9btJ["\155\145\147\x61\137\x66\151\154\x74\x65\162\137\160\154\x75\163"] = $this->config->get("\x6d\x66\151\154\164\145\162\137\160\154\165\x73\137\x76\x65\x72\x73\151\157\x6e");
        goto D98VS;
        kvCN7:
        $this->a6SedsPYaGpr6a = $DExNG;
        goto RxHf9;
        aYbzx:
        $Z9btJ = array("\155\145\147\x61\137\146\x69\154\164\x65\x72\x5f\x70\162\157" => $this->config->get("\x6d\x66\151\154\164\x65\162\x5f\x76\x65\162\x73\151\157\x6e"));
        goto CJGvb;
        sak3a:
        goto Cxdle;
        goto LOb9b;
        UBYTE:
        $vfdJd = array(0 => HTTP_SERVER);
        goto q_9xM;
        RxHf9:
        if (!(NULL != ($QLFHS = $this->config->get("\x6d\x66\x69\154\164\x65\x72\137\154\151\x63\x65\x6e\x73\145")))) {
            goto P70la;
        }
        goto q0qV_;
        Zd8b3:
    }
    public function __get($Z7cD6)
    {
        return $this->a6SedsPYaGpr6a->{$Z7cD6};
    }
    public function render($ico35)
    {
        goto QDWYh;
        V4etI:
        return;
        goto wngju;
        QMmdf:
        $BIh2Q["\150\x65\x61\x64\151\x6e\x67\137\x74\151\164\154\x65"] = $ico35[$ico35["\137\151\x64\x78"]]["\x74\151\164\x6c\145"][$this->config->get("\x63\157\x6e\x66\151\x67\x5f\154\141\x6e\x67\165\141\147\145\x5f\x69\x64")];
        goto Kbcma;
        ezRIc:
        yIkfI:
        goto A18KN;
        h2Pik:
        zLMCq:
        goto QBv5E;
        MtmoR:
        goto ZOdNE;
        goto IZ0jb;
        JeqOq:
        return;
        goto cAZmA;
        H9Vr5:
        uZthz:
        goto lNRbg;
        bg1T7:
        if (!empty($ico35[$ico35["\x5f\151\144\170"]]["\x73\x74\x61\164\165\x73"])) {
            goto OjGWC;
        }
        goto lc_XU;
        khNRE:
        $PbsWl = end($oqz0m);
        goto omNbx;
        HiT4C:
        if (in_array($BpWcw, $ico35[$ico35["\x5f\x69\x64\x78"]]["\143\x75\x73\x74\x6f\x6d\x65\162\137\147\x72\x6f\x75\160\x73"])) {
            goto D3EB6;
        }
        goto FMlGg;
        bsUtN:
        return;
        goto PRdya;
        HeMaR:
        if (in_array($this->config->get("\x63\x6f\156\146\151\x67\x5f\x73\164\157\162\x65\137\151\x64"), $ico35[$ico35["\x5f\151\144\170"]]["\163\x74\157\x72\x65\x5f\151\144"])) {
            goto k76tF;
        }
        goto xGZUs;
        uGci_:
        if (empty($ico35[$ico35["\x5f\x69\144\170"]]["\143\157\x6e\146\x69\x67\165\162\x61\164\151\157\x6e"])) {
            goto UIP22;
        }
        goto asQBn;
        GkdF0:
        $BpWcw = $this->customer->isLogged() ? $this->customer->getGroupId() : $this->config->get("\143\157\x6e\x66\151\147\x5f\x63\x75\163\164\157\x6d\x65\162\137\x67\x72\x6f\165\x70\x5f\151\144");
        goto HiT4C;
        J_NRO:
        y7Dug:
        goto RaFoX;
        DKnUI:
        $BIh2Q["\x5f\x72\157\x75\164\x65"] = base64_encode($sUtih->route());
        goto uygUh;
        NuV8b:
        OjGWC:
        goto HeMaR;
        RUybc:
        goto aPaaH;
        goto djfE1;
        XizjB:
        RCSxe:
        goto pdWjc;
        Y_w0E:
        fgHWz:
        goto DUoEo;
        lNRbg:
        if ($iYNpD) {
            goto NPvsA;
        }
        goto erft3;
        omNbx:
        if (in_array($PbsWl, $ico35[$ico35["\137\x69\144\x78"]]["\143\141\x74\x65\x67\x6f\162\x79\137\151\x64"])) {
            goto NB21n;
        }
        goto H3CFA;
        ZMTGq:
        cwX3z:
        goto A2get;
        G1JmI:
        $y1YLv = defined("\112\117\117\103\101\122\x54\137\123\x49\124\105\137\125\122\114") ? array("\x73\x69\x74\x65\x5f\165\x72\x6c" => $this->a4cvHrWPjoNj4a(JOOCART_SITE_URL), "\155\141\151\x6e\x5f\x75\162\154" => $this->a4cvHrWPjoNj4a($this->url->link('', '', "\x53\123\x4c"))) : false;
        goto AZBTD;
        zjQa1:
        $this->document->addStyle("\x63\x61\x74\x61\x6c\157\x67\x2f\166\151\x65\167\57\164\150\145\x6d\x65\57\x64\145\146\x61\165\x6c\164\x2f\163\164\171\154\145\x73\150\x65\145\x74\x2f\155\x66\57\x73\x74\171\154\145\x2e\143\x73\163\x3f\x76" . $BIh2Q["\x5f\x76"]);
        goto MtmoR;
        nituP:
        if (isset($ico35["\x5f\x69\x64\170"])) {
            goto jO3Ko;
        }
        goto r51zC;
        yuJIW:
        f1ejl:
        goto iPW3_;
        b4Nhl:
        if (class_exists("\x56\x51\115\157\x64")) {
            goto e_Vfg;
        }
        goto S2yP3;
        hCgo0:
        $o9HWw = "\x69\x64\x78\56" . $ico35["\137\x69\144\170"] . "\x2e" . $sUtih->cacheName();
        goto oR32s;
        bDy8F:
        foreach ($oqz0m as $PbsWl) {
            goto gsbBX;
            gsbBX:
            if (!in_array($PbsWl, $ico35[$ico35["\137\151\x64\170"]]["\150\151\144\145\x5f\x63\141\x74\145\x67\157\x72\x79\x5f\151\144"])) {
                goto EyHS3;
            }
            goto PEF4B;
            PEF4B:
            return;
            goto ROIaO;
            RWtp3:
            hZzV0:
            goto zWvnE;
            ROIaO:
            EyHS3:
            goto RWtp3;
            zWvnE:
        }
        goto ezRIc;
        k4zhZ:
        kSlwS:
        goto yuJIW;
        WP9tq:
        dzYxw:
        goto P5i4Z;
        IapA3:
        $BIh2Q["\163\145\x74\164\151\156\x67\x73"] = $eDH4c;
        goto kyQLJ;
        UbwEM:
        tMNQQ:
        goto zGrka;
        KJQW7:
        $BIh2Q["\x5f\151\144\170"] = $ico35["\x5f\151\x64\170"];
        goto DKnUI;
        DYnUO:
        gbjNJ:
        goto JQzqY;
        TfqwE:
        if (empty($eDH4c["\x63\x61\x63\150\x65\137\145\x6e\x61\142\x6c\145\x64"])) {
            goto I74Ci;
        }
        goto hCgo0;
        DUoEo:
        if (!(in_array($gUPJk, array("\160\x72\157\x64\165\143\164\x2f\x73\x65\x61\x72\143\150")) && empty($this->request->get["\163\x65\141\x72\143\x68"]) && empty($this->request->get["\164\x61\147"]))) {
            goto dzYxw;
        }
        goto C8ASF;
        jyjWL:
        MijoShop::get()->addHeader(JPATH_MIJOSHOP_OC . "\x2f\x63\141\164\x61\x6c\157\x67\x2f\x76\151\145\167\57\164\150\x65\x6d\x65\57\x64\x65\x66\141\165\x6c\x74\x2f\x73\164\x79\x6c\145\163\150\x65\x65\164\x2f\155\146\x2f\x73\164\171\x6c\x65\x2e\143\x73\163");
        goto p0Rs2;
        J0cOY:
        if (empty($ico35[$ico35["\137\151\x64\x78"]]["\143\x75\x73\164\157\155\x65\x72\137\x67\162\157\165\160\163"])) {
            goto y7Dug;
        }
        goto GkdF0;
        zGrka:
        if (file_exists(DIR_TEMPLATE . $this->config->get("\143\x6f\x6e\146\x69\x67\x5f\x74\x65\155\x70\154\x61\164\x65") . "\57\x74\x65\155\160\x6c\x61\164\x65\x2f\155\x6f\144\165\x6c\145\x2f\x6d\145\x67\x61\x5f\146\151\154\164\x65\x72\x2e\164\160\154")) {
            goto UfDTX;
        }
        goto oXO0z;
        QBv5E:
        $BIh2Q["\144\x69\162\145\x63\164\151\x6f\156"] = $this->language->get("\x64\151\162\145\x63\164\151\157\156");
        goto k7Plv;
        VJkO0:
        E3315:
        goto SYSHD;
        kd3zH:
        $ico35["\x66\x69\154\164\145\x72\x73"] = empty($ico35[$ico35["\137\x69\x64\170"]]["\x66\x69\154\x74\x65\162\163"]) ? array() : $ico35[$ico35["\137\151\144\x78"]]["\x66\x69\154\x74\x65\162\x73"];
        goto zQuJU;
        qSKxx:
        return;
        goto KSlkK;
        C7aeE:
        if ($PPLXo) {
            goto RCSxe;
        }
        goto lpP_v;
        Pj63n:
        return;
        goto lGa8S;
        AZBTD:
        if (class_exists("\126\121\x4d\x6f\x64")) {
            goto bfntn;
        }
        goto ApxEh;
        E6Prq:
        goto cUxzV;
        goto b6qTA;
        wngju:
        S4n7d:
        goto g966Y;
        JSWmg:
        cZXlG:
        goto uJF0g;
        JQzqY:
        if (!empty($ico35["\x6f\160\164\x69\x6f\x6e\163"])) {
            goto NcwyU;
        }
        goto bJcs7;
        wCRB2:
        $o9HWw = NULL;
        goto TfqwE;
        dfiky:
        $this->document->addStyle("\x63\141\x74\x61\154\157\x67\57\166\151\145\x77\57\164\x68\x65\x6d\x65\x2f\x64\145\146\x61\165\x6c\164\x2f\163\164\x79\154\145\163\x68\145\x65\x74\57\x6d\x66\x2f\163\x74\171\154\x65\55\62\56\143\x73\163\x3f\166" . $BIh2Q["\137\166"]);
        goto FI3YW;
        wApVu:
        Xe184:
        goto PGFiT;
        NLyg_:
        LmCjh:
        goto YwPr1;
        ABRBl:
        $OlNfM = Mobile_Detect_MFP::create()->isMobile();
        goto B5WRk;
        SYSHD:
        MijoShop::get()->addHeader(JPATH_MIJOSHOP_OC . "\x2f\143\141\164\x61\x6c\x6f\147\57\166\x69\145\x77\x2f\164\150\x65\155\145\57\144\145\146\141\165\154\x74\x2f\x73\x74\171\154\x65\163\x68\x65\145\x74\57\155\146\x2f\x73\x74\x79\154\145\x2d\62\x2e\x63\163\x73");
        goto UbwEM;
        lpP_v:
        $this->document->addScript("\x63\x61\164\x61\154\x6f\x67\x2f\x76\x69\145\167\x2f\152\141\x76\x61\163\143\162\x69\x70\x74\x2f\x6d\146\x2f\x69\163\143\x72\157\x6c\x6c\x2e\x6a\x73\77\166" . $BIh2Q["\137\166"]);
        goto A6NgM;
        e0oup:
        goto alrsA;
        goto v7BLE;
        zC8bT:
        K4EzY:
        goto b4Nhl;
        sjUaO:
        if (!isset($ico35[$ico35["\x5f\151\144\170"]]["\164\x69\164\154\145"][$this->config->get("\143\x6f\x6e\x66\x69\x67\137\154\x61\156\147\165\x61\147\145\137\151\144")])) {
            goto LRWgY;
        }
        goto QMmdf;
        B5WRk:
        if (!($ico35["\x70\x6f\x73\151\x74\x69\157\156"] == "\x63\157\156\x74\x65\156\164\137\164\157\x70" && !empty($eDH4c["\143\150\x61\x6e\x67\x65\x5f\164\157\x70\x5f\164\157\x5f\x63\157\154\165\155\x6e\x5f\157\x6e\137\x6d\157\x62\x69\154\x65"]) && $OlNfM)) {
            goto zLMCq;
        }
        goto L3k6p;
        xJUOu:
        $PbsWl = array_pop($oqz0m);
        goto Mo0Yp;
        RfL_k:
        alrsA:
        goto DQ2YM;
        fUDiR:
        NcwyU:
        goto Zgwsj;
        uZrcS:
        goto SmG7q;
        goto TlBFa;
        OZN8Y:
        $ico35["\143\x61\164\x65\147\157\162\x69\x65\x73"] = empty($ico35[$ico35["\137\x69\144\170"]]["\143\x61\x74\145\147\x6f\162\151\x65\x73"]) ? array() : $ico35[$ico35["\x5f\x69\x64\170"]]["\x63\141\x74\x65\x67\157\x72\x69\x65\163"];
        goto wApVu;
        hjzko:
        if (!(version_compare(VERSION, "\x32\x2e\x32\x2e\x30\56\60", "\x3e\75") && version_compare(VQMod::$_vqversion, "\62\x2e\x36\56\x31", "\x3c") && empty(VQMOD::$_virtualMFP))) {
            goto YV7G4;
        }
        goto BRrii;
        hYblg:
        if (!($BIh2Q["\x70\162\151\x63\145"]["\155\x69\156"] == 0 && $BIh2Q["\160\x72\151\143\145"]["\x6d\x61\x78"] == 0)) {
            goto oT9rI;
        }
        goto qJHTW;
        g966Y:
        $PPLXo = class_exists("\115\151\152\157\123\150\157\x70") ? true : false;
        goto G1JmI;
        W8oyd:
        $ct3b1 = $OQ0hS;
        goto KUO4t;
        kyQLJ:
        $BIh2Q["\x70\141\x72\141\155\163"] = $sUtih->getParseParams();
        goto KJQW7;
        u9YEO:
        if (!(in_array($gUPJk, array("\160\162\x6f\x64\x75\143\164\57\155\141\156\165\146\141\x63\x74\165\x72\x65\x72", "\160\x72\157\144\x75\x63\x74\57\x6d\x61\156\165\x66\x61\x63\164\x75\162\x65\162\x2f\151\x6e\146\x6f")) && isset($WASo5["\x6d\x61\x6e\165\x66\141\x63\x74\165\x72\145\162\x73"]))) {
            goto fgHWz;
        }
        goto MKz5u;
        L3k6p:
        $ico35["\160\157\x73\151\164\x69\x6f\x6e"] = "\x63\x6f\x6c\x75\155\156\x5f\x6c\x65\146\x74";
        goto heicm;
        lc_XU:
        return;
        goto NuV8b;
        Pr2Zk:
        $BIh2Q["\x61\x6a\x61\170\107\145\164\x43\x61\x74\x65\147\x6f\162\x79\x55\162\154"] = $this->a4cvHrWPjoNj4a($this->url->link("\x6d\x6f\144\x75\154\145\x2f\x6d\x65\147\x61\137\146\x69\154\164\x65\162\x2f\x67\145\164\143\x61\164\x65\147\157\162\151\145\163", '', "\123\x53\114"));
        goto XU7Ka;
        FojfU:
        MijoShop::getClass("\142\141\x73\x65")->addHeader(JPATH_MIJOSHOP_OC . "\x2f\x63\141\x74\x61\154\x6f\x67\57\x76\151\x65\x77\57\x6a\141\x76\x61\x73\143\162\151\x70\164\57\155\x66\x2f\155\145\x67\141\137\x66\151\x6c\164\x65\162\x2e\x6a\163", false);
        goto bzN4k;
        DyZ0R:
        if (!version_compare(VQMod::$_vqversion, "\62\56\65\56\x31", "\74")) {
            goto yK1XP;
        }
        goto pmGgR;
        pmGgR:
        $this->a3wEFbFRtPae3a("\x4d\x65\147\141\x20\x46\151\x6c\x74\145\162\x20\120\122\117\40\x74\x6f\40\167\157\162\153\40\160\x72\x6f\x70\145\162\x6c\x79\40\x72\x65\161\165\151\x72\145\x73\x20\126\121\x4d\x6f\x64\x20\151\156\40\166\145\x72\x73\x69\157\x6e\40\62\x2e\65\56\61\40\x6f\x72\x20\154\x61\164\x65\x72\56\74\x62\162\x20\57\76\131\157\x75\162\x20\x76\145\162\163\x69\x6f\156\40\157\146\x20\x56\121\x4d\x6f\144\40\151\x73\40\x74\x6f\157\40\157\154\x64\56\x20\120\x6c\x65\x61\x73\145\x20\x75\160\x67\x72\141\144\145\40\x69\164\40\x74\157\40\164\150\x65\40\154\x61\164\x65\163\x74\x20\x76\145\x72\163\151\x6f\x6e\x2e", true);
        goto zMNYW;
        qJHTW:
        $OQ0hS = array();
        goto FQo58;
        NBWnZ:
        $oqz0m = explode("\137", $this->request->get["\x70\141\164\x68"]);
        goto MRm3H;
        BXs6R:
        $this->document->addStyle("\x63\141\164\141\154\157\x67\57\166\151\x65\167\57\164\x68\x65\155\x65\57\x64\x65\x66\141\165\x6c\164\x2f\x73\x74\171\x6c\145\x73\x68\145\145\164\x2f\155\146\x2f\152\161\x75\145\x72\x79\55\x75\151\x2e\x6d\151\x6e\56\143\163\163\77\166" . $BIh2Q["\x5f\x76"]);
        goto AtmQo;
        P5i4Z:
        $BIh2Q["\160\162\151\143\145"] = $sUtih->getMinMaxPrice();
        goto hYblg;
        QDWYh:
        if ($this->config->get("\x6d\x66\x69\154\164\x65\x72\x5f\154\x69\143\x65\x6e\x73\145")) {
            goto K4EzY;
        }
        goto RtCie;
        TlBFa:
        UfDTX:
        goto PGkxd;
        CQPSo:
        akZZN:
        goto W8oyd;
        H3CFA:
        return false;
        goto Qq57f;
        E5nSK:
        if (empty($ico35[$ico35["\137\x69\x64\x78"]]["\150\151\144\x65\137\x63\x61\164\x65\x67\157\x72\171\x5f\151\x64"])) {
            goto sfnKP;
        }
        goto AFe6w;
        HqfN_:
        $this->a1vgzPkKNSXA1a($o9HWw, $ct3b1);
        goto NRIcY;
        H73er:
        $BIh2Q["\x68\151\144\145\x5f\x63\157\x6e\x74\141\x69\156\x65\x72"] = true;
        goto uFT_K;
        PELD4:
        if ($ct3b1) {
            goto S4n7d;
        }
        goto V4etI;
        y2lx6:
        if (empty($BIh2Q["\x64\151\x73\160\154\x61\x79\101\x6c\x77\x61\171\163\x41\163\127\x69\x64\x67\145\x74"])) {
            goto VuxI6;
        }
        goto H73er;
        fOO0G:
        if (!(!$o9HWw || NULL == ($ct3b1 = $this->a2mZwuGAWhuX2a($o9HWw)))) {
            goto cZXlG;
        }
        goto uk_yg;
        YhM6_:
        $BIh2Q["\x73\x65\x6f\137\141\x6c\x69\141\x73"] = empty($this->request->get["\155\146\x70\137\x73\x65\x6f\x5f\x61\154\x69\141\x73"]) ? '' : $this->request->get["\155\146\x70\137\163\145\157\x5f\141\154\151\141\163"];
        goto u9qKL;
        cONuX:
        if (!empty($ico35["\x63\141\164\x65\147\x6f\162\x69\x65\x73"])) {
            goto Xe184;
        }
        goto OZN8Y;
        bJcs7:
        $ico35["\x6f\x70\164\151\x6f\156\x73"] = empty($ico35[$ico35["\137\151\x64\170"]]["\157\x70\x74\151\x6f\x6e\163"]) ? array() : $ico35[$ico35["\137\151\x64\170"]]["\x6f\160\x74\151\x6f\x6e\x73"];
        goto fUDiR;
        erft3:
        return;
        goto ZZk2n;
        b6qTA:
        bfntn:
        goto mbtO_;
        MRm3H:
        if (!empty($ico35[$ico35["\x5f\x69\x64\170"]]["\143\x61\x74\x65\x67\x6f\x72\x79\x5f\x69\144\137\167\151\x74\x68\x5f\143\150\x69\154\144\x73"])) {
            goto IKIv2;
        }
        goto khNRE;
        BRrii:
        $this->a3wEFbFRtPae3a("\131\x6f\165\x72\40\117\160\x65\x6e\103\x61\162\x74\40\x72\145\161\165\151\162\x65\x73\40\x56\121\115\x6f\x64\40\151\x6e\x20\166\x65\x72\x73\151\x6f\x6e\x20\x32\56\66\x2e\x31\x20\x6f\162\40\x6c\x61\164\145\162\56\74\142\162\x20\x2f\76\131\x6f\x75\x72\x20\x76\x65\x72\x73\x69\157\156\40\x6f\146\x20\126\121\115\x6f\144\40\151\x73\x20\164\157\x6f\x20\157\154\144\x2e\40\120\x6c\x65\x61\163\x65\x20\x75\160\147\162\141\x64\145\40\x69\x74\x20\164\x6f\40\164\150\x65\x20\x6c\x61\164\145\163\164\40\166\145\x72\x73\x69\x6f\x6e\x2e", true);
        goto JeqOq;
        x6tKx:
        return;
        goto b67DU;
        b67DU:
        e_Vfg:
        goto DyZ0R;
        HS60c:
        $BIh2Q["\144\x69\163\x70\x6c\x61\171\101\x6c\167\141\x79\163\x41\163\127\151\144\x67\x65\x74"] = empty($ico35[$ico35["\137\x69\x64\x78"]]["\144\151\163\160\x6c\x61\171\137\x61\x6c\x77\x61\171\163\x5f\141\x73\x5f\167\x69\x64\x67\x65\x74"]) ? false : true;
        goto y2lx6;
        S2yP3:
        $this->a3wEFbFRtPae3a("\115\145\x67\141\x20\106\x69\154\x74\145\x72\40\x50\122\x4f\x20\x74\157\x20\167\x6f\x72\153\x20\x70\162\x6f\160\145\162\154\171\40\x72\145\161\x75\151\x72\x65\163\40\141\x6e\x20\x69\x6e\x73\164\141\x6c\154\145\144\x20\x56\x51\115\x6f\144\56", true);
        goto x6tKx;
        A18KN:
        aPaaH:
        goto pAidC;
        PRdya:
        jO3Ko:
        goto bg1T7;
        XU7Ka:
        $BIh2Q["\x69\x73\137\x6d\x6f\142\x69\x6c\145"] = $OlNfM;
        goto LmRA1;
        KUO4t:
        oT9rI:
        goto PELD4;
        FqBS5:
        $BIh2Q["\x5f\162\x6f\165\164\x65\x43\141\x74\145\x67\157\x72\x79"] = base64_encode("\x70\162\157\x64\x75\x63\x74\x2f\143\141\164\x65\x67\x6f\x72\x79");
        goto RjH_2;
        FQo58:
        foreach ($ct3b1 as $X0doh => $mnbdv) {
            goto MBUxR;
            MBUxR:
            if (!($mnbdv["\x62\x61\163\145\x5f\x74\171\x70\145"] != "\160\x72\151\x63\145")) {
                goto evdHV;
            }
            goto PJp5X;
            PJp5X:
            $OQ0hS[] = $mnbdv;
            goto WbwYS;
            WbwYS:
            evdHV:
            goto u25lU;
            u25lU:
            sIev0:
            goto bUTmy;
            bUTmy:
        }
        goto CQPSo;
        PGFiT:
        $eDH4c = $this->config->get("\x6d\145\x67\141\x5f\146\x69\154\x74\x65\x72\x5f\163\x65\164\164\151\x6e\x67\x73");
        goto uGci_;
        FI3YW:
        goto tMNQQ;
        goto XizjB;
        o3IzQ:
        $gUPJk = isset($this->request->get["\x72\x6f\x75\164\x65"]) ? $this->request->get["\162\x6f\165\164\145"] : NULL;
        goto u9YEO;
        uJF0g:
        $WASo5 = $this->a0llvKGJqpeM0a($ct3b1);
        goto o3IzQ;
        B1REZ:
        if (empty($ico35[$ico35["\x5f\x69\144\x78"]]["\143\x61\164\x65\147\157\x72\x79\x5f\151\x64"])) {
            goto oMkP4;
        }
        goto NBWnZ;
        RzYnT:
        MijoShop::get()->addHeader(JPATH_MIJOSHOP_OC . "\57\143\141\164\141\x6c\x6f\x67\57\166\x69\x65\x77\x2f\164\150\x65\x6d\x65\x2f" . $this->config->get("\143\x6f\156\146\x69\147\x5f\x74\145\155\160\154\141\164\145") . "\x2f\163\164\x79\154\145\x73\x68\x65\x65\164\x2f\155\146\57\163\164\171\x6c\145\x2e\x63\163\x73");
        goto VJkO0;
        UNjFd:
        $BIh2Q["\x66\x69\x6c\164\145\162\x73"] = $ct3b1;
        goto IapA3;
        FMlGg:
        return;
        goto Z8d_c;
        Zgwsj:
        if (!empty($ico35["\146\151\x6c\x74\x65\x72\163"])) {
            goto lvpKN;
        }
        goto kd3zH;
        uFT_K:
        VuxI6:
        goto C7aeE;
        LmRA1:
        $BIh2Q["\155\151\x6a\x6f\137\x73\x68\157\160"] = $PPLXo;
        goto Apa1q;
        XDEpw:
        $this->load->model("\x6d\157\x64\x75\154\x65\x2f\x6d\x65\x67\x61\137\x66\x69\154\164\145\x72");
        goto hH0_b;
        AtmQo:
        if (file_exists(DIR_TEMPLATE . $this->config->get("\143\x6f\156\x66\x69\x67\x5f\x74\x65\155\x70\x6c\x61\164\145") . "\57\163\164\171\x6c\145\x73\x68\145\145\x74\57\x6d\x66\x2f\163\x74\171\x6c\145\x2e\x63\163\x73")) {
            goto CIRkk;
        }
        goto zjQa1;
        xGZUs:
        return;
        goto JEWWT;
        zMNYW:
        return;
        goto glwEy;
        baB3D:
        $sUtih = MegaFilterCore::newInstance($this, NULL, array(), $eDH4c);
        goto wCRB2;
        oXO0z:
        return $this->load->view((version_compare(VERSION, "\x32\56\62\x2e\60\56\60", "\x3e\75") ? '' : "\144\x65\146\141\x75\x6c\x74\x2f\x74\x65\x6d\x70\154\x61\164\145\57") . "\155\x6f\144\165\x6c\x65\57\155\x65\147\141\x5f\x66\x69\154\x74\x65\x72\56\x74\x70\x6c", $BIh2Q);
        goto uZrcS;
        A6NgM:
        $this->document->addScript("\143\x61\x74\141\x6c\x6f\147\57\166\151\x65\x77\57\x6a\x61\166\x61\163\x63\162\x69\x70\x74\57\x6d\146\57\x6d\145\147\141\137\x66\x69\154\x74\x65\162\x2e\152\163\x3f\166" . $BIh2Q["\137\166"]);
        goto BXs6R;
        pAidC:
        sfnKP:
        goto k4zhZ;
        pdWjc:
        MijoShop::getClass("\x62\x61\163\x65")->addHeader(JPATH_MIJOSHOP_OC . "\57\x63\141\x74\141\x6c\157\147\x2f\x76\151\x65\x77\x2f\152\141\x76\141\x73\143\162\151\x70\164\57\x6d\x66\57\x69\x73\x63\162\x6f\154\x6c\56\x6a\x73", false);
        goto FojfU;
        GGjeS:
        XQr2F:
        goto RzYnT;
        hH94K:
        $BIh2Q["\x72\145\161\x75\145\163\164\x47\x65\164"] = $this->request->get;
        goto IEDOe;
        m0o4h:
        if (!(in_array($eDH4c["\154\x61\x79\157\x75\x74\137\143"], $ico35[$ico35["\x5f\x69\144\170"]]["\x6c\141\171\x6f\165\164\x5f\x69\144"]) && isset($this->request->get["\x70\141\164\150"]))) {
            goto kSlwS;
        }
        goto B1REZ;
        oR32s:
        I74Ci:
        goto fOO0G;
        uygUh:
        $BIh2Q["\x5f\162\157\165\164\x65\x50\x72\157\x64\165\143\164"] = base64_encode("\x70\162\x6f\x64\x75\x63\x74\57\x70\162\x6f\x64\x75\143\x74");
        goto FqBS5;
        IEDOe:
        $BIh2Q["\x5f\150\x6f\162\151\172\x6f\x6e\x74\x61\154\111\x6e\x6c\151\156\145"] = $ico35["\x70\157\163\151\164\x69\157\156"] == "\143\x6f\156\164\145\x6e\x74\137\x74\x6f\160" && !empty($ico35[$ico35["\x5f\x69\x64\x78"]]["\x69\156\154\x69\x6e\x65\x5f\x68\x6f\162\151\x7a\x6f\x6e\164\141\154"]) ? true : false;
        goto V37Zu;
        V37Zu:
        $BIh2Q["\163\x6d\x70"] = array("\151\x73\111\156\163\x74\141\x6c\154\145\144" => $this->config->get("\x73\x6d\x70\x5f\151\163\137\151\x6e\x73\x74\141\x6c\154"), "\144\x69\x73\141\142\x6c\145\x43\157\156\166\145\162\x74\x55\x72\154\163" => $this->config->get("\x73\155\x70\137\x64\151\x73\x61\142\x6c\145\137\143\x6f\156\166\x65\x72\x74\x5f\165\x72\x6c\163"));
        goto WkEOb;
        BuXwh:
        if (!empty($ico35[$ico35["\x5f\x69\144\170"]]["\x68\151\144\145\137\x63\141\164\x65\147\x6f\162\x79\x5f\x69\144\x5f\x77\151\164\x68\x5f\x63\x68\x69\154\x64\163"])) {
            goto xqIiU;
        }
        goto xJUOu;
        heicm:
        $BIh2Q["\x68\151\x64\x65\137\x63\x6f\x6e\164\141\151\x6e\145\x72"] = true;
        goto h2Pik;
        mbtO_:
        require_once VQMod::modCheck(modification(DIR_SYSTEM . "\x6c\151\x62\x72\141\162\171\x2f\x6d\x66\x69\x6c\x74\x65\x72\x5f\x6d\157\x62\x69\x6c\145\x2e\x70\x68\x70"));
        goto l372j;
        asQBn:
        foreach ($ico35[$ico35["\137\151\x64\x78"]]["\143\157\156\146\151\x67\165\x72\x61\164\151\x6f\x6e"] as $X0doh => $mnbdv) {
            $eDH4c[$X0doh] = $mnbdv;
            KVr7I:
        }
        goto ZMTGq;
        DQ2YM:
        oMkP4:
        goto E5nSK;
        ujkH7:
        SmG7q:
        goto EOJJE;
        CgX6K:
        $BIh2Q["\147\145\164\123\171\x6d\142\157\154\x52\151\147\150\164"] = $this->currency->getSymbolRight(isset($this->session->data["\143\165\x72\162\145\156\x63\171"]) ? $this->session->data["\143\165\162\x72\x65\x6e\143\171"] : '');
        goto hH94K;
        uk_yg:
        $ct3b1 = $this->model_module_mega_filter->getAttributes($sUtih, $ico35["\x5f\151\x64\170"], $ico35["\142\x61\x73\x65\137\x61\x74\x74\162\x69\x62\163"], $ico35["\x61\x74\164\162\151\x62\x73"], $ico35["\x6f\160\164\151\x6f\156\163"], $ico35["\146\x69\x6c\x74\145\x72\163"], empty($ico35["\143\x61\164\145\147\157\x72\x69\x65\x73"]) ? array() : $ico35["\x63\141\164\x65\147\157\162\151\145\163"]);
        goto x688k;
        PGkxd:
        return $this->load->view((version_compare(VERSION, "\x32\56\x32\x2e\60\56\x30", "\76\75") ? '' : $this->config->get("\143\x6f\x6e\146\151\147\x5f\164\x65\x6d\x70\154\141\164\x65") . "\57\164\145\x6d\x70\x6c\x61\x74\145\x2f") . "\x6d\157\x64\x75\x6c\x65\x2f\x6d\145\x67\x61\x5f\x66\x69\x6c\x74\x65\162\x2e\164\x70\x6c", $BIh2Q);
        goto ujkH7;
        k7Plv:
        $BIh2Q["\141\x6a\x61\170\x47\x65\164\111\x6e\146\157\x55\162\x6c"] = $this->a4cvHrWPjoNj4a($this->url->link("\x6d\157\144\165\x6c\145\x2f\155\145\147\141\137\146\x69\154\x74\x65\x72\x2f\147\x65\x74\x61\x6a\141\170\x69\x6e\x66\157", '', "\123\x53\114"));
        goto qo77Z;
        rZ1k0:
        if (!(isset($ico35[$ico35["\137\x69\x64\170"]]["\x6c\141\x79\x6f\165\164\x5f\x69\144"]) && is_array($ico35[$ico35["\x5f\151\x64\x78"]]["\x6c\x61\x79\x6f\x75\164\137\x69\144"]))) {
            goto f1ejl;
        }
        goto m0o4h;
        v7BLE:
        IKIv2:
        goto wv8HJ;
        lGa8S:
        CJZqy:
        goto J0cOY;
        opTT7:
        $BIh2Q["\147\x65\164\x53\171\155\142\x6f\154\x4c\x65\x66\164"] = $this->currency->getSymbolLeft(isset($this->session->data["\x63\x75\x72\x72\x65\x6e\143\x79"]) ? $this->session->data["\143\165\162\162\145\156\143\171"] : '');
        goto CgX6K;
        SKhgx:
        if (!empty($ico35["\x62\141\163\x65\x5f\141\x74\x74\x72\151\142\x73"])) {
            goto LmCjh;
        }
        goto shIQZ;
        NRIcY:
        lyIpX:
        goto JSWmg;
        RtCie:
        return;
        goto zC8bT;
        Qq57f:
        NB21n:
        goto e0oup;
        Kbcma:
        LRWgY:
        goto XDEpw;
        bzN4k:
        if (file_exists(DIR_TEMPLATE . $this->config->get("\x63\x6f\156\146\151\x67\x5f\x74\145\155\x70\x6c\141\164\x65") . "\57\x73\164\171\154\145\163\x68\x65\x65\164\x2f\x6d\x66\x2f\163\164\171\154\x65\x2e\x63\163\x73")) {
            goto XQr2F;
        }
        goto jyjWL;
        AFe6w:
        $oqz0m = explode("\137", $this->request->get["\x70\141\164\150"]);
        goto BuXwh;
        A2get:
        UIP22:
        goto rZ1k0;
        hH0_b:
        $this->model_module_mega_filter->setSettings($eDH4c);
        goto baB3D;
        cAZmA:
        YV7G4:
        goto nituP;
        iPW3_:
        if (!(isset($ico35[$ico35["\x5f\151\x64\x78"]]["\163\x74\157\x72\x65\x5f\x69\x64"]) && is_array($ico35[$ico35["\x5f\151\144\170"]]["\163\164\157\162\145\137\151\x64"]) && !in_array($this->config->get("\x63\157\156\146\x69\147\137\163\164\157\162\145\x5f\151\x64"), $ico35[$ico35["\137\151\x64\x78"]]["\x73\164\157\162\145\137\151\144"]))) {
            goto CJZqy;
        }
        goto Pj63n;
        C8ASF:
        $ct3b1 = array();
        goto WP9tq;
        p0Rs2:
        goto E3315;
        goto GGjeS;
        glwEy:
        yK1XP:
        goto hjzko;
        Apa1q:
        $BIh2Q["\x6a\157\157\x5f\143\141\162\x74"] = $y1YLv;
        goto UNjFd;
        djfE1:
        xqIiU:
        goto bDy8F;
        IZ0jb:
        CIRkk:
        goto d8nCm;
        GS5Zr:
        $ico35["\x61\x74\164\x72\151\x62\x73"] = empty($ico35[$ico35["\137\x69\144\170"]]["\141\164\x74\x72\x69\142\x73"]) ? array() : $ico35[$ico35["\137\151\144\170"]]["\141\164\164\162\x69\142\163"];
        goto DYnUO;
        RaFoX:
        $BIh2Q = $this->language->load("\x6d\157\144\x75\154\x65\57\155\145\x67\141\x5f\146\x69\x6c\x74\145\x72");
        goto sjUaO;
        ApxEh:
        require_once modification(DIR_SYSTEM . "\x6c\x69\x62\x72\x61\162\171\57\155\146\x69\x6c\164\145\162\x5f\x6d\x6f\x62\151\x6c\145\x2e\x70\x68\160");
        goto E6Prq;
        x688k:
        if (empty($eDH4c["\x63\141\x63\150\145\137\145\156\141\x62\154\x65\x64"])) {
            goto lyIpX;
        }
        goto HqfN_;
        l372j:
        cUxzV:
        goto ABRBl;
        Z8d_c:
        D3EB6:
        goto J_NRO;
        qo77Z:
        $BIh2Q["\x61\x6a\141\170\122\145\x73\165\x6c\x74\163\x55\162\154"] = $this->a4cvHrWPjoNj4a($this->url->link("\155\x6f\144\165\x6c\145\x2f\x6d\x65\147\x61\137\x66\151\x6c\x74\145\162\x2f\162\145\163\x75\154\x74\163", '', "\123\x53\114"));
        goto Pr2Zk;
        Mo0Yp:
        if (!in_array($PbsWl, $ico35[$ico35["\137\151\x64\x78"]]["\x68\x69\144\x65\x5f\x63\141\x74\x65\147\x6f\162\171\x5f\151\x64"])) {
            goto UOkz7;
        }
        goto qSKxx;
        wv8HJ:
        $iYNpD = false;
        goto uZjvP;
        KSlkK:
        UOkz7:
        goto RUybc;
        JEWWT:
        k76tF:
        goto SKhgx;
        zQuJU:
        lvpKN:
        goto cONuX;
        WkEOb:
        $BIh2Q["\163\x65\157"] = $this->config->get("\x6d\x65\147\141\x5f\x66\x69\x6c\164\145\x72\137\163\x65\157");
        goto YhM6_;
        YwPr1:
        if (!empty($ico35["\x61\164\x74\162\x69\x62\x73"])) {
            goto gbjNJ;
        }
        goto GS5Zr;
        LH10C:
        $BIh2Q["\137\160\157\163\x69\164\x69\157\156"] = $ico35["\160\x6f\163\x69\x74\151\157\x6e"];
        goto opTT7;
        r51zC:
        $this->a3wEFbFRtPae3a("\x54\150\x65\162\145\x20\151\x73\x20\x61\40\x63\x6f\x6e\146\154\151\143\x74\x20\x4d\x65\147\141\x20\106\x69\154\164\145\x72\x20\120\x52\x4f\x20\x77\151\x74\x68\40\x79\157\165\162\x20\164\145\155\160\154\141\x74\145\40\157\x72\40\157\164\150\x65\x72\40\145\x78\x74\145\156\163\x69\157\156\40\x2d\40\x3c\x61\x20\150\x72\145\x66\x3d\x22\150\x74\x74\160\x3a\57\x2f\x66\157\x72\x75\x6d\56\157\143\x64\x65\155\157\56\145\x75\x2f\42\40\164\141\x72\147\x65\x74\75\x22\x5f\x62\x6c\141\x6e\x6b\42\40\x73\x74\x79\x6c\145\x3d\x22\x74\145\170\164\55\x64\145\x63\157\162\141\x74\x69\157\x6e\x3a\x75\156\x64\x65\x72\x6c\x69\156\x65\x22\x3e\160\x6c\145\x61\x73\x65\x20\x66\151\156\144\x20\x61\x20\163\x6f\x6c\x75\x74\x69\157\156\x20\x6f\156\x20\157\x75\x72\x20\146\x6f\162\x75\155\x3c\57\141\x3e\56");
        goto bsUtN;
        u9qKL:
        $BIh2Q["\x5f\166"] = $this->config->get("\155\146\151\x6c\164\x65\x72\x5f\x76\145\x72\x73\x69\157\x6e") ? $this->config->get("\155\146\151\x6c\164\x65\x72\137\166\145\x72\x73\151\157\x6e") : "\61";
        goto HS60c;
        jz9N3:
        ZOdNE:
        goto dfiky;
        uZjvP:
        foreach ($oqz0m as $PbsWl) {
            goto dAxpZ;
            WCydu:
            $iYNpD = true;
            goto hL4XG;
            hL4XG:
            goto uZthz;
            goto nbDiF;
            EIgKq:
            nHmnI:
            goto g1rBz;
            nbDiF:
            VKRPj:
            goto EIgKq;
            dAxpZ:
            if (!in_array($PbsWl, $ico35[$ico35["\x5f\x69\144\x78"]]["\143\141\164\145\147\157\x72\x79\x5f\x69\144"])) {
                goto VKRPj;
            }
            goto WCydu;
            g1rBz:
        }
        goto H9Vr5;
        MKz5u:
        unset($ct3b1[$WASo5["\x6d\x61\x6e\x75\x66\141\143\x74\165\x72\x65\x72\x73"]]);
        goto Y_w0E;
        ZZk2n:
        NPvsA:
        goto RfL_k;
        RjH_2:
        $BIh2Q["\137\x72\x6f\x75\164\x65\x48\x6f\155\145"] = base64_encode("\x63\157\155\x6d\157\x6e\x2f\x68\157\155\x65");
        goto LH10C;
        d8nCm:
        $this->document->addStyle("\143\141\x74\141\154\x6f\x67\x2f\x76\151\145\x77\57\164\150\145\x6d\145\x2f" . $this->config->get("\x63\157\156\146\x69\147\137\x74\x65\x6d\x70\x6c\x61\x74\x65") . "\x2f\163\164\x79\154\145\x73\x68\145\x65\x74\57\x6d\x66\x2f\163\x74\x79\x6c\145\x2e\143\163\163\x3f\166" . $BIh2Q["\137\x76"]);
        goto jz9N3;
        shIQZ:
        $ico35["\x62\x61\163\145\x5f\x61\x74\x74\162\151\142\163"] = empty($ico35[$ico35["\x5f\151\x64\x78"]]["\x62\x61\163\145\x5f\141\164\164\162\151\142\163"]) ? array() : $ico35[$ico35["\x5f\151\x64\170"]]["\142\x61\x73\x65\x5f\x61\x74\164\162\x69\x62\163"];
        goto NLyg_;
        EOJJE:
    }
}