<?php

namespace Database\Seeders;

use App\Models\Township;
use Illuminate\Database\Seeder;

class TownshipSeeder extends Seeder
{
    public function run(): void
    {
        $townships = [

            /*
            |--------------------------------------------------------------------------
            | Yangon Region
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Yangon',
                'mm_name' => 'ရန်ကုန်',
                'region_name' => 'Yangon',
                'region_mm_name' => 'ရန်ကုန်တိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Hlaing',
                'mm_name' => 'လှိုင်',
                'region_name' => 'Yangon',
                'region_mm_name' => 'ရန်ကုန်တိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Kamayut',
                'mm_name' => 'ကမာရွတ်',
                'region_name' => 'Yangon',
                'region_mm_name' => 'ရန်ကုန်တိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Mayangone',
                'mm_name' => 'မရမ်းကုန်း',
                'region_name' => 'Yangon',
                'region_mm_name' => 'ရန်ကုန်တိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Mingaladon',
                'mm_name' => 'မင်္ဂလာဒုံ',
                'region_name' => 'Yangon',
                'region_mm_name' => 'ရန်ကုန်တိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Insein',
                'mm_name' => 'အင်းစိန်',
                'region_name' => 'Yangon',
                'region_mm_name' => 'ရန်ကုန်တိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Thingangyun',
                'mm_name' => 'သင်္ဃန်းကျွန်း',
                'region_name' => 'Yangon',
                'region_mm_name' => 'ရန်ကုန်တိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Tamwe',
                'mm_name' => 'တာမွေ',
                'region_name' => 'Yangon',
                'region_mm_name' => 'ရန်ကုန်တိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'North Okkalapa',
                'mm_name' => 'မြောက်ဥက္ကလာပ',
                'region_name' => 'Yangon',
                'region_mm_name' => 'ရန်ကုန်တိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'South Okkalapa',
                'mm_name' => 'တောင်ဥက္ကလာပ',
                'region_name' => 'Yangon',
                'region_mm_name' => 'ရန်ကုန်တိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Hlaing Tharyar',
                'mm_name' => 'လှိုင်သာယာ',
                'region_name' => 'Yangon',
                'region_mm_name' => 'ရန်ကုန်တိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Thanlyin',
                'mm_name' => 'သန်လျင်',
                'region_name' => 'Yangon',
                'region_mm_name' => 'ရန်ကုန်တိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],

            /*
            |--------------------------------------------------------------------------
            | Mandalay Region
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Mandalay',
                'mm_name' => 'မန္တလေး',
                'region_name' => 'Mandalay',
                'region_mm_name' => 'မန္တလေးတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Amarapura',
                'mm_name' => 'အမရပူရ',
                'region_name' => 'Mandalay',
                'region_mm_name' => 'မန္တလေးတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Pyin Oo Lwin',
                'mm_name' => 'ပြင်ဦးလွင်',
                'region_name' => 'Mandalay',
                'region_mm_name' => 'မန္တလေးတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Meiktila',
                'mm_name' => 'မိတ္ထီလာ',
                'region_name' => 'Mandalay',
                'region_mm_name' => 'မန္တလေးတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Myingyan',
                'mm_name' => 'မြင်းခြံ',
                'region_name' => 'Mandalay',
                'region_mm_name' => 'မန္တလေးတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Kyaukse',
                'mm_name' => 'ကျောက်ဆည်',
                'region_name' => 'Mandalay',
                'region_mm_name' => 'မန္တလေးတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Nyaung-U',
                'mm_name' => 'ညောင်ဦး',
                'region_name' => 'Mandalay',
                'region_mm_name' => 'မန္တလေးတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],

            /*
            |--------------------------------------------------------------------------
            | Nay Pyi Taw Union Territory
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Zabuthiri',
                'mm_name' => 'ဇမ္ဗူသီရိ',
                'region_name' => 'Nay Pyi Taw',
                'region_mm_name' => 'နေပြည်တော် ပြည်ထောင်စုနယ်မြေ',
                'region_type' => 'Union Territory',
            ],
            [
                'name' => 'Ottarathiri',
                'mm_name' => 'ဥတ္တရသီရိ',
                'region_name' => 'Nay Pyi Taw',
                'region_mm_name' => 'နေပြည်တော် ပြည်ထောင်စုနယ်မြေ',
                'region_type' => 'Union Territory',
            ],
            [
                'name' => 'Dekkhinathiri',
                'mm_name' => 'ဒက္ခိဏသီရိ',
                'region_name' => 'Nay Pyi Taw',
                'region_mm_name' => 'နေပြည်တော် ပြည်ထောင်စုနယ်မြေ',
                'region_type' => 'Union Territory',
            ],
            [
                'name' => 'Pyinmana',
                'mm_name' => 'ပျဉ်းမနား',
                'region_name' => 'Nay Pyi Taw',
                'region_mm_name' => 'နေပြည်တော် ပြည်ထောင်စုနယ်မြေ',
                'region_type' => 'Union Territory',
            ],
            [
                'name' => 'Lewe',
                'mm_name' => 'လယ်ဝေး',
                'region_name' => 'Nay Pyi Taw',
                'region_mm_name' => 'နေပြည်တော် ပြည်ထောင်စုနယ်မြေ',
                'region_type' => 'Union Territory',
            ],
            [
                'name' => 'Tatkon',
                'mm_name' => 'တပ်ကုန်း',
                'region_name' => 'Nay Pyi Taw',
                'region_mm_name' => 'နေပြည်တော် ပြည်ထောင်စုနယ်မြေ',
                'region_type' => 'Union Territory',
            ],

            /*
            |--------------------------------------------------------------------------
            | Bago Region
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Bago',
                'mm_name' => 'ပဲခူး',
                'region_name' => 'Bago',
                'region_mm_name' => 'ပဲခူးတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Taungoo',
                'mm_name' => 'တောင်ငူ',
                'region_name' => 'Bago',
                'region_mm_name' => 'ပဲခူးတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Pyay',
                'mm_name' => 'ပြည်',
                'region_name' => 'Bago',
                'region_mm_name' => 'ပဲခူးတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Nyaunglebin',
                'mm_name' => 'ညောင်လေးပင်',
                'region_name' => 'Bago',
                'region_mm_name' => 'ပဲခူးတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],

            /*
            |--------------------------------------------------------------------------
            | Ayeyarwady Region
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Pathein',
                'mm_name' => 'ပုသိမ်',
                'region_name' => 'Ayeyarwady',
                'region_mm_name' => 'ဧရာဝတီတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Hinthada',
                'mm_name' => 'ဟင်္သာတ',
                'region_name' => 'Ayeyarwady',
                'region_mm_name' => 'ဧရာဝတီတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Myaungmya',
                'mm_name' => 'မြောင်းမြ',
                'region_name' => 'Ayeyarwady',
                'region_mm_name' => 'ဧရာဝတီတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Maubin',
                'mm_name' => 'မအူပင်',
                'region_name' => 'Ayeyarwady',
                'region_mm_name' => 'ဧရာဝတီတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Pyapon',
                'mm_name' => 'ဖျာပုံ',
                'region_name' => 'Ayeyarwady',
                'region_mm_name' => 'ဧရာဝတီတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],

            /*
            |--------------------------------------------------------------------------
            | Magway Region
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Magway',
                'mm_name' => 'မကွေး',
                'region_name' => 'Magway',
                'region_mm_name' => 'မကွေးတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Pakokku',
                'mm_name' => 'ပခုက္ကူ',
                'region_name' => 'Magway',
                'region_mm_name' => 'မကွေးတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Minbu',
                'mm_name' => 'မင်းဘူး',
                'region_name' => 'Magway',
                'region_mm_name' => 'မကွေးတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Chauk',
                'mm_name' => 'ချောက်',
                'region_name' => 'Magway',
                'region_mm_name' => 'မကွေးတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Aunglan',
                'mm_name' => 'အောင်လံ',
                'region_name' => 'Magway',
                'region_mm_name' => 'မကွေးတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],

            /*
            |--------------------------------------------------------------------------
            | Sagaing Region
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Sagaing',
                'mm_name' => 'စစ်ကိုင်း',
                'region_name' => 'Sagaing',
                'region_mm_name' => 'စစ်ကိုင်းတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Monywa',
                'mm_name' => 'မုံရွာ',
                'region_name' => 'Sagaing',
                'region_mm_name' => 'စစ်ကိုင်းတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Shwebo',
                'mm_name' => 'ရွှေဘို',
                'region_name' => 'Sagaing',
                'region_mm_name' => 'စစ်ကိုင်းတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Kalay',
                'mm_name' => 'ကလေး',
                'region_name' => 'Sagaing',
                'region_mm_name' => 'စစ်ကိုင်းတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],

            /*
            |--------------------------------------------------------------------------
            | Shan State
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Taunggyi',
                'mm_name' => 'တောင်ကြီး',
                'region_name' => 'Shan',
                'region_mm_name' => 'ရှမ်းပြည်နယ်',
                'region_type' => 'State',
            ],
            [
                'name' => 'Kalaw',
                'mm_name' => 'ကလော',
                'region_name' => 'Shan',
                'region_mm_name' => 'ရှမ်းပြည်နယ်',
                'region_type' => 'State',
            ],
            [
                'name' => 'Nyaungshwe',
                'mm_name' => 'ညောင်ရွှေ',
                'region_name' => 'Shan',
                'region_mm_name' => 'ရှမ်းပြည်နယ်',
                'region_type' => 'State',
            ],
            [
                'name' => 'Lashio',
                'mm_name' => 'လားရှိုး',
                'region_name' => 'Shan',
                'region_mm_name' => 'ရှမ်းပြည်နယ်',
                'region_type' => 'State',
            ],
            [
                'name' => 'Muse',
                'mm_name' => 'မူဆယ်',
                'region_name' => 'Shan',
                'region_mm_name' => 'ရှမ်းပြည်နယ်',
                'region_type' => 'State',
            ],
            [
                'name' => 'Tachileik',
                'mm_name' => 'တာချီလိတ်',
                'region_name' => 'Shan',
                'region_mm_name' => 'ရှမ်းပြည်နယ်',
                'region_type' => 'State',
            ],
            [
                'name' => 'Kengtung',
                'mm_name' => 'ကျိုင်းတုံ',
                'region_name' => 'Shan',
                'region_mm_name' => 'ရှမ်းပြည်နယ်',
                'region_type' => 'State',
            ],

            /*
            |--------------------------------------------------------------------------
            | Mon State
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Mawlamyine',
                'mm_name' => 'မော်လမြိုင်',
                'region_name' => 'Mon',
                'region_mm_name' => 'မွန်ပြည်နယ်',
                'region_type' => 'State',
            ],
            [
                'name' => 'Thaton',
                'mm_name' => 'သထုံ',
                'region_name' => 'Mon',
                'region_mm_name' => 'မွန်ပြည်နယ်',
                'region_type' => 'State',
            ],
            [
                'name' => 'Kyaikto',
                'mm_name' => 'ကျိုက်ထို',
                'region_name' => 'Mon',
                'region_mm_name' => 'မွန်ပြည်နယ်',
                'region_type' => 'State',
            ],

            /*
            |--------------------------------------------------------------------------
            | Kayin State
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Hpa-An',
                'mm_name' => 'ဘားအံ',
                'region_name' => 'Kayin',
                'region_mm_name' => 'ကရင်ပြည်နယ်',
                'region_type' => 'State',
            ],
            [
                'name' => 'Myawaddy',
                'mm_name' => 'မြဝတီ',
                'region_name' => 'Kayin',
                'region_mm_name' => 'ကရင်ပြည်နယ်',
                'region_type' => 'State',
            ],

            /*
            |--------------------------------------------------------------------------
            | Kachin State
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Myitkyina',
                'mm_name' => 'မြစ်ကြီးနား',
                'region_name' => 'Kachin',
                'region_mm_name' => 'ကချင်ပြည်နယ်',
                'region_type' => 'State',
            ],
            [
                'name' => 'Bhamo',
                'mm_name' => 'ဗန်းမော်',
                'region_name' => 'Kachin',
                'region_mm_name' => 'ကချင်ပြည်နယ်',
                'region_type' => 'State',
            ],

            /*
            |--------------------------------------------------------------------------
            | Rakhine State
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Sittwe',
                'mm_name' => 'စစ်တွေ',
                'region_name' => 'Rakhine',
                'region_mm_name' => 'ရခိုင်ပြည်နယ်',
                'region_type' => 'State',
            ],
            [
                'name' => 'Thandwe',
                'mm_name' => 'သံတွဲ',
                'region_name' => 'Rakhine',
                'region_mm_name' => 'ရခိုင်ပြည်နယ်',
                'region_type' => 'State',
            ],
            [
                'name' => 'Kyaukpyu',
                'mm_name' => 'ကျောက်ဖြူ',
                'region_name' => 'Rakhine',
                'region_mm_name' => 'ရခိုင်ပြည်နယ်',
                'region_type' => 'State',
            ],
            [
                'name' => 'Mrauk-U',
                'mm_name' => 'မြောက်ဦး',
                'region_name' => 'Rakhine',
                'region_mm_name' => 'ရခိုင်ပြည်နယ်',
                'region_type' => 'State',
            ],

            /*
            |--------------------------------------------------------------------------
            | Chin State
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Hakha',
                'mm_name' => 'ဟားခါး',
                'region_name' => 'Chin',
                'region_mm_name' => 'ချင်းပြည်နယ်',
                'region_type' => 'State',
            ],
            [
                'name' => 'Falam',
                'mm_name' => 'ဖလမ်း',
                'region_name' => 'Chin',
                'region_mm_name' => 'ချင်းပြည်နယ်',
                'region_type' => 'State',
            ],
            [
                'name' => 'Mindat',
                'mm_name' => 'မင်းတပ်',
                'region_name' => 'Chin',
                'region_mm_name' => 'ချင်းပြည်နယ်',
                'region_type' => 'State',
            ],

            /*
            |--------------------------------------------------------------------------
            | Kayah State
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Loikaw',
                'mm_name' => 'လွိုင်ကော်',
                'region_name' => 'Kayah',
                'region_mm_name' => 'ကယားပြည်နယ်',
                'region_type' => 'State',
            ],
            [
                'name' => 'Demoso',
                'mm_name' => 'ဒီးမော့ဆို',
                'region_name' => 'Kayah',
                'region_mm_name' => 'ကယားပြည်နယ်',
                'region_type' => 'State',
            ],

            /*
            |--------------------------------------------------------------------------
            | Tanintharyi Region
            |--------------------------------------------------------------------------
            */
            [
                'name' => 'Dawei',
                'mm_name' => 'ထားဝယ်',
                'region_name' => 'Tanintharyi',
                'region_mm_name' => 'တနင်္သာရီတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Myeik',
                'mm_name' => 'မြိတ်',
                'region_name' => 'Tanintharyi',
                'region_mm_name' => 'တနင်္သာရီတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
            [
                'name' => 'Kawthaung',
                'mm_name' => 'ကော့သောင်း',
                'region_name' => 'Tanintharyi',
                'region_mm_name' => 'တနင်္သာရီတိုင်းဒေသကြီး',
                'region_type' => 'Region',
            ],
        ];

        foreach ($townships as $township) {
            Township::updateOrCreate(
                [
                    'region_name' => $township['region_name'],
                    'name' => $township['name'],
                ],
                $township
            );
        }
    }
}