<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Kapal;
use App\Models\Ftit;

class DepotSyncSeeder extends Seeder
{
    public function run()
    {
        $csvData = <<<'CSV'
nama_kapal,nama_depot
KLM. AISYAH,Depot Bima
KLM. AL FATAH,Depot Bima
KLM. BERKAH BUANA INDAH,Depot Bima
KLM. BUANA SUTRA,Depot Bima
,
KLM. BUNGA BUANA KARYA,Depot Bima
,
KLM. CAHAYA ZULFAJRUL 01,Depot Bima
KLM. CITRA NUSANTARA INDAH,Depot Bima
KLM. DARMA SURYA,Depot Bima
KLM. DHARMA MALULU,Depot Bima
KLM. DHARMA NUSANTARA,Depot Bima
KLM. DUTA AGUNG,Depot Bima
KLM. DUTA BAHTERA,Depot Bima
KLM. DUTA KENCANA,Depot Bima
KLM. DUTA NUSANTARA,Depot Bima
KLM. DUTA PERSADA,Depot Bima
KLM. DUTA SAMUDRA,Depot Bima
KLM. FAHRIL AKBAR,Depot Bima
KLM. FEBRIAN PUTRA,Depot Bima
KLM. HASIL FAJRUL UTAMA,Depot Bima
KLM. HASTA,Depot Bima
KLM. ISAH MULIA,Depot Bima
KLM. KARTIKA MULYA,Depot Bima
KLM. MITRA BAHARI,Depot Bima
KLM. MITRA NUSANTARA,Depot Bima
KLM. MOH. IHSAN RAMADHANI,Depot Bima
KLM. NURHAYATI MAS,Depot Bima
KLM. RAHMAT SETIA-02,Depot Bima
KLM. ROSYITA,Depot Bima
KLM. SARTIKA MULYA,Depot Bima
KLM. SAUDARAKU,Depot Bima
KLM. SINAR HARAPAN 01,Depot Bima
KLM. SINAR RESKI II,Depot Bima
KLM. TANJUNG PANDAN INDAH,Depot Bima
KLM. TUNAS BUNGA BAHARI,Depot Bima
KLM.BINA SURGA VI,Depot Bima
KM SEMAYA DARMAJAYA JET,TT Manggis
KM. AMUKTI PALAPA,Depot Bima
KM. AQUA STAR,IT TENAU Kupang
KM. ARTHA MULIA 1,IT TENAU Kupang
KM. ASIA RAYA,Depot Waingapu
KM. AWU,Inst. Surabaya
KM. BERGUNA,Depot Bima
KM. BERKAT TALODA,IT TENAU Kupang
KM. BINTANG 28,Depot Waingapu
KM. BUNG TOMO,Depot Camplong
KM. CAHAYA BARU 03,Depot Maumere
KM. CAMARA NUSANTARA 1,IT TENAU Kupang
KM. CAMARA NUSANTARA 2,IT TENAU Kupang
KM. CAMARA NUSANTARA 3,IT TENAU Kupang
KM. CAMARA NUSANTARA 4,IT TENAU Kupang
KM. CAMARA NUSANTARA 5,IT TENAU Kupang
KM. CAMARA NUSANTARA 6,IT TENAU Kupang
KM. CANTIKA LESTARI 9C,IT TENAU Kupang
KM. CANTIKA LESTARI 9E,IT TENAU Kupang
KM. CITRA BARU I,Depot Bima
KM. DHARMA FERRY V,Inst. Surabaya
KM. DHARMA FERRY VI,Inst. Surabaya
KM. DHARMA FERRY VII,Inst. Surabaya
KM. DHARMA KARTIKA II,Inst. Surabaya
KM. DHARMA KARTIKA III,Inst. Surabaya
KM. DHARMA KARTIKA IX,Inst. Surabaya
KM. DHARMA KARTIKA V,Depot Ampenan
,IT TENAU Kupang
,Depot Waingapu
,Inst. Surabaya
KM. DHARMA KENCANA III,Inst. Surabaya
KM. DHARMA KENCANA V,Inst. Surabaya
KM. DHARMA KENCANA VII,Inst. Surabaya
KM. DHARMA RUCITRA I,Inst. Surabaya
KM. DHARMA RUCITRA VII,Depot Ampenan
,Depot Maumere
,Inst. Surabaya
KM. DHARMA RUCITRA VIII,Depot Ampenan
,Depot Ende
,Inst. Surabaya
KM. DLN MANDALIKA,Inst. Surabaya
KM. DLN NUSANTARA,Inst. Surabaya
KM. DOROLONDA,Inst. Surabaya
KM. EGON,Inst. Surabaya
KM. EKA JAYA 23,TT Manggis
KM. EKA JAYA 25,TT Manggis
KM. EKA JAYA 26,TT Manggis
KM. EKAJAYA MATRA,TT Manggis
KM. EXPRESS BAHARI 1F,IT TENAU Kupang
,Depot Tanjung Wangi
KM. EXPRESS BAHARI 7F,IT TENAU Kupang
KM. EXPRESS BAHARI 8E,IT TENAU Kupang
KM. GANDHA NUSANTARA 10,IT TENAU Kupang
KM. GANDHA NUSANTARA 12,Depot Maumere
KM. GANDHA NUSANTARA 14,Depot Maumere
KM. GANDHA NUSANTARA 20,Depot Reo
KM. GANDHA NUSANTARA 9,Depot Bima
KM. HAI DA,Inst. Surabaya
KM. KELIMUTU,Inst. Surabaya
KM. KENDHAGA NUSANTARA 10,Inst. Surabaya
KM. KENDHAGA NUSANTARA 11,IT TENAU Kupang
KM. KENDHAGA NUSANTARA 12,Inst. Surabaya
KM. KENDHAGA NUSANTARA 3,Inst. Surabaya
KM. KENDHAGA NUSANTARA 5,Inst. Surabaya
KM. KENDHAGA NUSANTARA 7,IT TENAU Kupang
KM. KENDHAGA NUSANTARA 9,Inst. Surabaya
KM. KIRANA,Inst. Surabaya
KM. KIRANA I,Inst. Surabaya
KM. KIRANA III,Inst. Surabaya
KM. KIRANA VII,Depot Ampenan
,Inst. Surabaya
KM. KUTAI RAYA DUA,Inst. Surabaya
KM. LABOBAR,Inst. Surabaya
KM. LAWIT,Inst. Surabaya
KM. LEUSER,Inst. Surabaya
KM. LINTAS PAPUA,Depot Camplong
KM. LOGISTIK NUSANTARA 1,Inst. Surabaya
KM. LOGISTIK NUSANTARA 2,Inst. Surabaya
KM. LOGISTIK NUSANTARA 3,Inst. Surabaya
KM. LOGISTIK NUSANTARA 5,Inst. Surabaya
KM. LOGISTIK NUSANTARA 6,Inst. Surabaya
KM. MALOLI,Depot Reo
KM. MILA UTAMA,Depot Ende
,Inst. Surabaya
KM. MUTIARA BARAT,Depot Ampenan
,Depot Tanjung Wangi
,Inst. Surabaya
KM. MUTIARA BERKAH II,Depot Tanjung Wangi
,Inst. Surabaya
KM. MUTIARA FERINDO I,Inst. Surabaya
KM. MUTIARA FERINDO II,Depot Ampenan
,Depot Tanjung Wangi
,Inst. Surabaya
KM. MUTIARA FERINDO VII,Inst. Surabaya
KM. MUTIARA PERSADA II,Inst. Surabaya
KM. MUTIARA PERSADA III,Depot Ampenan
,Inst. Surabaya
,Depot Tanjung Wangi
KM. MUTIARA SENTOSA II,Inst. Surabaya
KM. MUTIARA SENTOSA III,Depot Ampenan
,Depot Tanjung Wangi
KM. NADELYN K,Depot Reo
KM. NEW GLORY,Inst. Surabaya
KM. NIKI MILA UTAMA,Depot Ende
,Inst. Surabaya
KM. NIKI SEJAHTERA,Depot Ende
,Inst. Surabaya
KM. SABUK NUSANTARA 101,Depot Maumere
KM. SABUK NUSANTARA 107,Depot Maumere
KM. SABUK NUSANTARA 108,IT TENAU Kupang
KM. SABUK NUSANTARA 27,Depot Bima
KM. SABUK NUSANTARA 31,Depot Maumere
KM. SABUK NUSANTARA 43,Depot Waingapu
KM. SABUK NUSANTARA 49,Depot Bima
KM. SABUK NUSANTARA 51,Depot Bima
KM. SABUK NUSANTARA 55,IT TENAU Kupang
KM. SABUK NUSANTARA 74,Depot Camplong
KM. SABUK NUSANTARA 79,Depot Waingapu
KM. SABUK NUSANTARA 90,IT TENAU Kupang
KM. SABUK NUSANTARA 91,Depot Tanjung Wangi
,Inst. Surabaya
KM. SABUK NUSANTARA 92,Inst. Surabaya
KM. SELVI PRATIWI,Depot Maumere
KM. SINABUNG,Inst. Surabaya
KM. SIRIMAU,IT TENAU Kupang
KM. WILIS,IT TENAU Kupang
KMP. BELIDA,Depot Ampenan
KMP. CAKALANG,Depot Bima
KMP. CAKALANG II,IT TENAU Kupang
KMP. CUCUT,Depot Bima
KMP. DHARMA FERRY IX,Depot Ampenan
KMP. DHARMA FERRY VIII,Depot Ampenan
KMP. DHARMA KENCANA,Inst. Surabaya
KMP. DHARMA KENCANA IX,Depot Ampenan
KMP. DLN BATU LAYAR,Inst. Surabaya
KMP. DLN OASIS,Inst. Surabaya
KMP. DRAJAT PACIRAN,Inst. Surabaya
KMP. GADING NUSANTARA,TT Manggis
KMP. GARDA MARITIM 3,IT TENAU Kupang
KMP. GARDA MARITIM 6,Depot Ampenan
KMP. GARDA MARITIM 8,Depot Ampenan
KMP. GARDA MARITIM I,Depot Ampenan
KMP. GARDA MARITIM II,Depot Ampenan
KMP. GEMILANG VIII,Depot Ampenan
KMP. GERBANG SAMUDRA 3,TT Manggis
KMP. GILI IYANG,Inst. Surabaya
KMP. ILE MANDIRI,Depot Kalabahi
KMP. ILEAPE,Depot Maumere
,
KMP. ILELABALEKAN,IT TENAU Kupang
KMP. INERIE II,IT TENAU Kupang
KMP. JAMBO X,Depot Ampenan
KMP. JAMBO XI,Inst. Surabaya
KMP. JAMBO XII,Depot Ampenan
KMP. JATRA-II,Depot Ampenan
KMP. JAX,Depot Ampenan
KMP. JEMLA FAJAR,Depot Ampenan
KMP. JOKOTOLE,Inst. Surabaya
KMP. KALEBI,Depot Ampenan
KMP. KALIBODRI,IT TENAU Kupang
KMP. KOMODO,Depot Reo
KMP. LAKAAN,IT TENAU Kupang
KMP. LIBERTY 01,Depot Ampenan
KMP. MARINA PRIMERA,TT Manggis
KMP. MARINA QUINTA,Depot Ampenan
KMP. MARINA SEGUNDA,TT Manggis
KMP. MARINA TERTIERA,Depot Ampenan
KMP. MARISA NUSANTARA,Depot Ampenan
KMP. MUNIC 1,TT Manggis
KMP. MUNIC III,TT Manggis
KMP. MUTIARA ALAS I,Depot Ampenan
KMP. MUTIARA ALAS II,Depot Ampenan
KMP. MUTIARA ALAS III,Depot Ampenan
KMP. MUTIARA INDONESIA,Depot Ampenan
KMP. NAMPARNOS,Depot Kalabahi
KMP. NARAYA,Depot Ampenan
KMP. NAWASENA,Depot Ampenan
KMP. NUSA BHAKTI,Depot Ampenan
KMP. NUSA JAYA ABADI,TT Manggis
KMP. NUSA SEJAHTERA,KMP. NUSA SEJAHTERA
KMP. NUSA SENTOSA,Depot Ampenan
KMP. NUSA WANGI I,Depot Ampenan
KMP. PARAMA KALYANI,Depot Ampenan
KMP. PBK MURYATI,Depot Ampenan
KMP. PELANGI NUSANTARA,Depot Ampenan
KMP. PERMATA LESTARI II,Depot Ampenan
KMP. PERTIWI NUSANTARA,Depot Ampenan
KMP. PORTLINK II,TT Manggis
KMP. PRIMA NUSANTARA,TT Manggis
KMP. PUTRI GIANYAR,Depot Ampenan
KMP. PUTRI YASMIN,Depot Ampenan
KMP. RAJA ENGGANO,Depot Ampenan
KMP. RANAKA,IT TENAU Kupang
KMP. RHAMA GIRI NUSA,TT Manggis
KMP. RODITHA,TT Manggis
KMP. SALINDO MUTIARA-I,TT Manggis
KMP. SATYA DHARMA,Depot Ampenan
KMP. SHITA GIRI NUSA,TT Manggis
KMP. SINDU DWITAMA,Depot Ampenan
KMP. SINDU TRITAMA,Depot Ampenan
KMP. SIRUNG,IT TENAU Kupang
KMP. SURAMADU NUSANTARA,Depot Ampenan
KMP. SURYA 777,Depot Ampenan
KMP. SURYA KAYANGAN,Depot Ampenan
KMP. SWARNA CAKRA,Depot Ampenan
KMP. TONGKOL,Inst. Surabaya
KMP. TRIMAS ELLISA,Depot Ampenan
KMP. TRIMAS LAILA,Depot Ampenan
KMP. TUNU PRATAMA JAYA 5888,Depot Ampenan
KMP. UMA KALADA,Depot Kupang
KMP. WICITRA DHARMA,Depot Ampenan
KMP. WIHAN BAHARI,Depot Ampenan
MV. MIKO NATALIA - 89,TT Manggis
MV. OCEANNA 19,TT Manggis
KMP. PULAU SABU,Depot Atapupu
CSV;

        $depotMap = [
            'depot reo' => 'FT01',
            'depot waingapu' => 'FT02',
            'depot benoa/sanggaran' => 'FT03',
            'depot tanjung wangi' => 'FT04',
            'depot maumere' => 'FT05',
            'depot camplong' => 'FT06',
            'depot kupang' => 'FT07',
            'it tenau kupang' => 'FT07',
            'depot kalabahi' => 'FT08',
            'tt manggis' => 'FT09',
            'depot bima' => 'FT10',
            'depot ende' => 'FT11',
            'depot ampenan' => 'FT12',
            'inst. surabaya' => 'FT13',
            'depot atapupu' => 'FT14',
        ];

        // Clear existing many-to-many links
        DB::table('kapal_ftit')->truncate();

        $lines = explode("\n", $csvData);
        $currentShipName = '';
        $matchedCount = 0;
        $unmatchedShips = [];
        $unmappedDepots = [];

        // Store mappings to sync later
        $shipDepots = [];

        foreach ($lines as $index => $line) {
            if ($index === 0) continue; // Skip header
            $line = trim($line);
            if (empty($line)) continue;

            $parts = str_getcsv($line);
            $shipNameInput = isset($parts[0]) ? trim($parts[0]) : '';
            $depotNameInput = isset($parts[1]) ? trim($parts[1]) : '';

            // Handle continuation lines starting with a comma (ship name is empty)
            if (empty($shipNameInput)) {
                $shipNameInput = $currentShipName;
            } else {
                $currentShipName = $shipNameInput;
            }

            if (empty($shipNameInput) || empty($depotNameInput)) {
                continue;
            }

            // Find depot code
            $depotKey = strtolower($depotNameInput);
            if (!isset($depotMap[$depotKey])) {
                $unmappedDepots[$depotNameInput] = true;
                continue;
            }
            $depotId = $depotMap[$depotKey];

            // Accumulate depots for each ship
            if (!isset($shipDepots[$shipNameInput])) {
                $shipDepots[$shipNameInput] = [];
            }
            if (!in_array($depotId, $shipDepots[$shipNameInput])) {
                $shipDepots[$shipNameInput][] = $depotId;
            }
        }

        foreach ($shipDepots as $shipName => $depotIds) {
            // Find ship in database by name
            $kapal = Kapal::where('nama_kapal', $shipName)->first();

            // If not found, try a case-insensitive check or soundex/like
            if (!$kapal) {
                $kapal = Kapal::whereRaw('LOWER(nama_kapal) = ?', [strtolower($shipName)])->first();
            }

            if ($kapal) {
                // Sync the many-to-many relationship
                $kapal->depots()->sync($depotIds);

                // Also update the single id_ftit column for backward compatibility (using the first depot)
                if (!empty($depotIds)) {
                    $kapal->id_ftit = $depotIds[0];
                    $kapal->save();
                }

                $matchedCount++;
            } else {
                $unmatchedShips[] = $shipName;
            }
        }

        $this->command->info("Successfully matched and synced {$matchedCount} ships.");
        if (!empty($unmatchedShips)) {
            $this->command->warn("The following ships in the CSV could not be matched in the database:\n" . implode("\n", array_unique($unmatchedShips)));
        }
        if (!empty($unmappedDepots)) {
            $this->command->error("The following depots in the CSV were not recognized:\n" . implode("\n", array_keys($unmappedDepots)));
        }
    }
}
