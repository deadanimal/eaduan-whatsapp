<?php

namespace App\Repositories;

use DB;

class MyIdentityDataRepository
{
    /**
     * @param array $array
     */
    public static function grabData($response)
    {
        $AgencyCode = $response['AgencyCode'] ?? null;
        $BranchCode = $response['BranchCode'] ?? null;
        $UserId = $response['UserId'] ?? null;
        $TransactionCode = $response['TransactionCode'] ?? null;
        $ReplyDateTime = $response['ReplyDateTime'] ?? null;
        // $ReplyIndicator = trim($response['ReplyIndicator']) ?? null;
        $ReplyIndicator = isset($response['ReplyIndicator']) ? trim($response['ReplyIndicator']) : null;
        $ICNumber = $response['ICNumber'] ?? null;
        $Name = isset($response['Name']) ? $response['Name'] : null;
        $DateOfBirth = isset($response['DateOfBirth']) ? $response['DateOfBirth'] : null;
        $Gender = isset($response['Gender']) ? $response['Gender'] : null;
        $Race = isset($response['Race']) ? $response['Race'] : null;
        $Religion = isset($response['Religion']) ? $response['Religion'] : null;
        $PermanentAddress1 = isset($response['PermanentAddress1']) ? $response['PermanentAddress1'] : null;
        $PermanentAddress2 = isset($response['PermanentAddress2']) ? $response['PermanentAddress2'] : null;
        $PermanentAddress3 = isset($response['PermanentAddress3']) ? $response['PermanentAddress3'] : null;
        $PermanentAddressPostcode = isset($response['PermanentAddressPostcode']) ? $response['PermanentAddressPostcode'] : null;
        $PermanentAddressCityCode = isset($response['PermanentAddressCityCode']) ? $response['PermanentAddressCityCode'] : null;
        $PermanentAddressCityDesc = isset($response['PermanentAddressCityDesc']) ? $response['PermanentAddressCityDesc'] : null;
        $PermanentAddressStateCode = isset($response['PermanentAddressStateCode']) ? $response['PermanentAddressStateCode'] : null;
        $CorrespondenceAddress1 = isset($response['CorrespondenceAddress1']) ? $response['CorrespondenceAddress1'] : null;
        $CorrespondenceAddress2 = isset($response['CorrespondenceAddress2']) ? $response['CorrespondenceAddress2'] : null;
        $CorrespondenceAddress3 = isset($response['CorrespondenceAddress3']) ? $response['CorrespondenceAddress3'] : null;
        $CorrespondenceAddress4 = isset($response['CorrespondenceAddress4']) ? $response['CorrespondenceAddress4'] : null;
        $CorrespondenceAddress5 = isset($response['CorrespondenceAddress5']) ? $response['CorrespondenceAddress5'] : null;
        $CorrespondenceAddressPostcode = isset($response['CorrespondenceAddressPostcode']) ? $response['CorrespondenceAddressPostcode'] : null;
        $CorrespondenceAddressCityCode = isset($response['CorrespondenceAddressCityCode']) ? $response['CorrespondenceAddressCityCode'] : null;
        $CorrespondenceAddressCityDescription = isset($response['CorrespondenceAddressCityDescription']) ? $response['CorrespondenceAddressCityDescription'] : null;
        $CorrespondenceAddressStateCode = isset($response['CorrespondenceAddressStateCode']) ? $response['CorrespondenceAddressStateCode'] : null;
        $CorrespondenceAddressCountryCode = isset($response['CorrespondenceAddressCountryCode']) ? $response['CorrespondenceAddressCountryCode'] : null;
        $OldICnumber = isset($response['OldICnumber']) ? $response['OldICnumber'] : null;
        $DateOfDeath = isset($response['DateOfDeath']) ? $response['DateOfDeath'] : null;
        $CitizenshipStatus = isset($response['CitizenshipStatus']) ? $response['CitizenshipStatus'] : null;
        $ResidentialStatus = isset($response['ResidentialStatus']) ? trim($response['ResidentialStatus']) : null;
        $EmailAddress = isset($response['EmailAddress']) ? $response['EmailAddress'] : null;
        $MobilePhoneNumber = isset($response['MobilePhoneNumber']) ? $response['MobilePhoneNumber'] : null;
        $AddressStatus = isset($response['AddressStatus']) ? $response['AddressStatus'] : null;
        $RecordStatus = isset($response['RecordStatus']) ? trim($response['RecordStatus']) : null;
        $NewICNumber = isset($response['NewICNumber']) ? $response['NewICNumber'] : null;
        $CorrespondenceAddressUpdateDate = isset($response['CorrespondenceAddressUpdateDate']) ? $response['CorrespondenceAddressUpdateDate'] : null;
        $CorrespondenceAddressUpdateBy = isset($response['CorrespondenceAddressUpdateBy']) ? $response['CorrespondenceAddressUpdateBy'] : null;
        $VerifyStatus = isset($response['VerifyStatus']) ? $response['VerifyStatus'] : null;
        $MessageCode = isset($response['MessageCode']) ? $response['MessageCode'] : null;
        $Message = isset($response['Message']) ? $response['Message'] : null;

        $proceedgetdata = false;
        if ($ReplyIndicator == '1' || $ReplyIndicator == '2') { //1 - Success  2 - Alert)
            /* if (($nocheckname)) {
                $matchname=true;
            }else {
                // untuk buang space dalam nama yg disi dan nama dari jpn kemudian bandingkan
                $matchname= (strtoupper(implode(explode(' ',$Name))) == strtoupper(implode(explode(' ',$Nama_Pengadu))))?true:false;
            } */
            //if ($matchname){
            if ($ResidentialStatus == 'B' ||
                $ResidentialStatus == 'C' ||
                $ResidentialStatus == 'M' ||
                $ResidentialStatus == 'P' ||
                $ResidentialStatus == ''
            ) { // Warganegara dan Pemastautin Tetap
                if ($RecordStatus == '2' ||
                    $RecordStatus == 'B' ||
                    $RecordStatus == 'H') { // Sudah Meninggal
                    $Msg = "Individu direkodkan telah meninggal dunia";
                    $Message = $Msg;
                    $StatusPengadu = '6'; // Individu direkodkan telah meninggal dunia
                    $proceedgetdata = true; // kalu nok juga data
                } else {
                    // Dapatkan rekod jpn letak dlm array
                    $Msg = "";
                    $proceedgetdata = true;
                    if ($ResidentialStatus == 'B' ||
                        $ResidentialStatus == 'C') {
                        $StatusPengadu = '1';  // Warganegara
                        $Msg = "Warganegara";
                    } else {
                        $StatusPengadu = '2'; // Pemastautin Tetap
                        $Msg = "Pemastautin Tetap";
                    }

                }
            } else {
                $Msg = "Bukan Warga Negara";
                $proceedgetdata = true;
                $StatusPengadu = '3'; // Bukan Warganegara
            }
            //} else {
            //$Msg = "Nama tidak sepadan dengan Kad Pengenalan";
            //$StatusPengadu='4'; // Nama tidak sama dengan No. kp
            //}
        } else {
            //$Msg = "No. Kp tiada dalam pangkalan data MyIdentiti"; // Status Pengadu = 4
            if (($ReplyIndicator == null) || (isset($MessageCode) && in_array($MessageCode, ["CRS0010"]))) {
                $Msg = "Masalah teknikal";
                $StatusPengadu = '7'; // Masalah teknikal
            } else {
                $Msg = "No. Kad Pengenalan/Pasport Tidak Sah";
                $StatusPengadu = '5'; // No. Kp tidak Sah
            }
        }

        $arr = array();
        $arr['AgencyCode'] = $AgencyCode;
        $arr['BranchCode'] = $BranchCode;
        $arr['UserId'] = $UserId;
        $arr['ICNumber'] = $ICNumber;
        $arr['TransactionCode'] = $TransactionCode;
        $arr['StatusPengadu'] = $StatusPengadu;
        $arr['Msg'] = $Msg;
        $arr['ReplyIndicator'] = $ReplyIndicator;
        $arr['ResidentialStatus'] = $ResidentialStatus;
        $arr['RecordStatus'] = $RecordStatus;
        $arr['Message'] = $Message;
        $arr['Name'] = $Name;
        $arr['CorrespondenceAddress1'] = trim($CorrespondenceAddress1);
        $arr['CorrespondenceAddress2'] = trim($CorrespondenceAddress2);
        $arr['CorrespondenceAddressPostcode'] = trim($CorrespondenceAddressPostcode);
        $arr['CorrespondenceAddressCityCode'] = trim($CorrespondenceAddressCityCode);
        $arr['CorrespondenceAddressCityDescription'] = trim($CorrespondenceAddressCityDescription);
        $arr['CorrespondenceAddressStateCode'] = trim($CorrespondenceAddressStateCode);
        $arr['CorrespondenceAddressCountryCode'] = trim($CorrespondenceAddressCountryCode);
        $arr['EmailAddress'] = trim($EmailAddress);
        $arr['MobilePhoneNumber'] = trim(str_ireplace("-", "", $MobilePhoneNumber));
        $arr['Gender'] = ($Gender == null) ? '' : (($Gender == 'L') ? 'M' : 'F');
        $arr['DateOfBirth'] = trim($DateOfBirth);
        $arr['Race'] = $Race;
        $arr['ReplyDateTime'] = $ReplyDateTime;
        $arr['MessageLog'] = $Msg;
        if ($arr['DateOfBirth'] != '') {
            $arr['Age'] = date_diff(date_create($arr['DateOfBirth']), date_create('today'))->y;
        } else {
            $arr['Age'] = '';
        }
        $RaceCode = trim($Race);
        $arr['RaceCode'] = $RaceCode;
        if (!empty($RaceCode)) { // BANGSA
            if ($RaceCode == '0100') { // MELAYU
                $mRefRaceCode = DB::table('sys_ref')
                    ->select('code')
                    ->where(['cat' => '580'])
                    ->where('descr', 'like', "%melayu%")
                    ->first();
                if ($mRefRaceCode) {
                    $mRefRace = $mRefRaceCode->code;
                } else {
                    $mRefRace = '';
                }
            } else if ($RaceCode == '0200') { // CINA
                $mRefRaceCode = DB::table('sys_ref')
                    ->select('code')
                    ->where(['cat' => '580'])
                    ->where('descr', 'like', "%cina%")
                    ->first();
                if ($mRefRaceCode) {
                    $mRefRace = $mRefRaceCode->code;
                } else {
                    $mRefRace = '';
                }
            } else if ($RaceCode == '0300') { // INDIA
                $mRefRaceCode = DB::table('sys_ref')
                    ->select('code')
                    ->where(['cat' => '580'])
                    ->where('descr', 'like', "%india%")
                    ->first();
                if ($mRefRaceCode) {
                    $mRefRace = $mRefRaceCode->code;
                } else {
                    $mRefRace = '';
                }
            } else if ($RaceCode == '0800') { // BUMIPUTERA SABAH
                $mRefRaceCode = DB::table('sys_ref')
                    ->select('code')
                    ->where(['cat' => '580'])
                    ->where('descr', 'like', "%sabah%")
                    ->first();
                if ($mRefRaceCode) {
                    $mRefRace = $mRefRaceCode->code;
                } else {
                    $mRefRace = '';
                }
            } else if ($RaceCode == '1000') { // BUMIPUTERA SARAWAK
                $mRefRaceCode = DB::table('sys_ref')
                    ->select('code')
                    ->where(['cat' => '580'])
                    ->where('descr', 'like', "%sarawak%")
                    ->first();
                if ($mRefRaceCode) {
                    $mRefRace = $mRefRaceCode->code;
                } else {
                    $mRefRace = '';
                }
            } else if ($RaceCode == '0000' || $RaceCode == '9999') { // TIADA MAKLUMAT
                $mRefRace = '';
            } else { // LAIN-LAIN
                $mRefRaceCode = DB::table('sys_ref')
                    ->select('code')
                    ->where(['cat' => '580'])
                    ->where('descr', 'like', "%lain%")
                    ->first();
                if ($mRefRaceCode) {
                    $mRefRace = $mRefRaceCode->code;
                } else {
                    $mRefRace = '';
                }
            }
        } else {
            $mRefRace = '';
        }
        $arr['RaceCd'] = $mRefRace;
        if ($ResidentialStatus == 'B' ||
            $ResidentialStatus == 'C' ||
            $ResidentialStatus == 'M' ||
            $ResidentialStatus == 'P' ||
            $ResidentialStatus == '') {
            $arr['Warganegara'] = '1';
            $arr['WarganegaraInfo'] = 'Warganegara/Pemastautin Tetap';
        } else {
            $arr['Warganegara'] = '0';
            $arr['WarganegaraInfo'] = 'Lain-lain';
        }
        // Daerah
        if ($arr['CorrespondenceAddressCityCode'] != '') {
            $KodDaerahEaduan = DB::table('kodmapping')->select('kodsistem')->where(['koddiberi' => $arr['CorrespondenceAddressCityCode']])->first();
            if ($KodDaerahEaduan == '') {
                $arr['KodDaerah'] = '';
            } else {
                $arr['KodDaerah'] = $KodDaerahEaduan->kodsistem;
            }
        } else {
            $arr['KodDaerah'] = '';
        }

        return $arr;
    }
}
