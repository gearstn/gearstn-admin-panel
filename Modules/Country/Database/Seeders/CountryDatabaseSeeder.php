<?php

namespace Modules\Country\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CountryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $countries = [
        //     array('id' => '1','title_ar' => 'أندورا','title_en' => 'Andorra','code' => 'ad'),
        //     array('id' => '2','title_ar' => 'الإمارات العربية المتحدة','title_en' => 'United Arab Emirates','code' => 'ae'),
        //     array('id' => '3','title_ar' => 'أفغانستان','title_en' => 'Afghanistan','code' => 'af'),
        //     array('id' => '4','title_ar' => 'أنتيغوا وبربودا','title_en' => 'Antigua and Barbuda','code' => 'ag'),
        //     array('id' => '5','title_ar' => 'أنغيلا','title_en' => 'Anguilla','code' => 'ai'),
        //     array('id' => '6','title_ar' => 'ألبانيا','title_en' => 'Albania','code' => 'al'),
        //     array('id' => '7','title_ar' => 'أرمينيا','title_en' => 'Armenia','code' => 'am'),
        //     array('id' => '8','title_ar' => 'جزر الأنتيل الهولندية','title_en' => 'Netherlands Antilles','code' => 'an'),
        //     array('id' => '9','title_ar' => 'أنغولا','title_en' => 'Angola','code' => 'ao'),
        //     array('id' => '10','title_ar' => 'الأرجنتين','title_en' => 'Argentina','code' => 'ar'),
        //     array('id' => '11','title_ar' => 'النمسا','title_en' => 'Austria','code' => 'at'),
        //     array('id' => '12','title_ar' => 'أستراليا','title_en' => 'Australia','code' => 'au'),
        //     array('id' => '13','title_ar' => 'أروبا','title_en' => 'Aruba','code' => 'aw'),
        //     array('id' => '14','title_ar' => 'أذربيجان','title_en' => 'Azerbaijan','code' => 'az'),
        //     array('id' => '15','title_ar' => 'البوسنة والهرسك','title_en' => 'Bosnia and Herzegovina','code' => 'ba'),
        //     array('id' => '16','title_ar' => 'بربادوس','title_en' => 'Barbados','code' => 'bb'),
        //     array('id' => '17','title_ar' => 'بنغلاديش','title_en' => 'Bangladesh','code' => 'bd'),
        //     array('id' => '18','title_ar' => 'بلجيكا','title_en' => 'Belgium','code' => 'be'),
        //     array('id' => '19','title_ar' => 'بوركينا فاسو','title_en' => 'Burkina Faso','code' => 'bf'),
        //     array('id' => '20','title_ar' => 'بلغاريا','title_en' => 'Bulgaria','code' => 'bg'),
        //     array('id' => '21','title_ar' => 'البحرين','title_en' => 'Bahrain','code' => 'bh'),
        //     array('id' => '22','title_ar' => 'بوروندي','title_en' => 'Burundi','code' => 'bi'),
        //     array('id' => '23','title_ar' => 'بنين','title_en' => 'Benin','code' => 'bj'),
        //     array('id' => '24','title_ar' => 'برمودا','title_en' => 'Bermuda','code' => 'bm'),
        //     array('id' => '25','title_ar' => 'بروناي دار السلام','title_en' => 'Brunei Darussalam','code' => 'bn'),
        //     array('id' => '26','title_ar' => 'بوليفيا','title_en' => 'Bolivia','code' => 'bo'),
        //     array('id' => '27','title_ar' => 'البرازيل','title_en' => 'Brazil','code' => 'br'),
        //     array('id' => '28','title_ar' => 'الباهاما','title_en' => 'Bahamas','code' => 'bs'),
        //     array('id' => '29','title_ar' => 'بوتان','title_en' => 'Bhutan','code' => 'bt'),
        //     array('id' => '30','title_ar' => 'بوتسوانا','title_en' => 'Botswana','code' => 'bw'),
        //     array('id' => '31','title_ar' => 'روسيا البيضاء','title_en' => 'Belarus','code' => 'by'),
        //     array('id' => '32','title_ar' => 'بليز','title_en' => 'Belize','code' => 'bz'),
        //     array('id' => '33','title_ar' => 'كندا','title_en' => 'Canada','code' => 'ca'),
        //     array('id' => '34','title_ar' => 'جزر كوكوس (كيلينغ)','title_en' => 'Cocos (Keeling) Islands','code' => 'cc'),
        //     array('id' => '35','title_ar' => 'جمهورية الكونغو الديموقراطية','title_en' => 'Democratic Republic of the Congo','code' => 'cd'),
        //     array('id' => '36','title_ar' => 'جمهورية افريقيا الوسطى','title_en' => 'Central African Republic','code' => 'cf'),
        //     array('id' => '37','title_ar' => 'الكونغو','title_en' => 'Congo','code' => 'cg'),
        //     array('id' => '38','title_ar' => 'سويسرا','title_en' => 'Switzerland','code' => 'ch'),
        //     array('id' => '39','title_ar' => 'ساحل العاج (ساحل العاج)','title_en' => 'Cote D\'Ivoire (Ivory Coast)','code' => 'ci'),
        //     array('id' => '40','title_ar' => 'جزر كوك','title_en' => 'Cook Islands','code' => 'ck'),
        //     array('id' => '41','title_ar' => 'تشيلي','title_en' => 'Chile','code' => 'cl'),
        //     array('id' => '42','title_ar' => 'الكاميرون','title_en' => 'Cameroon','code' => 'cm'),
        //     array('id' => '43','title_ar' => 'الصين','title_en' => 'China','code' => 'cn'),
        //     array('id' => '44','title_ar' => 'كولومبيا','title_en' => 'Colombia','code' => 'co'),
        //     array('id' => '45','title_ar' => 'كوستا ريكا','title_en' => 'Costa Rica','code' => 'cr'),
        //     array('id' => '46','title_ar' => 'كوبا','title_en' => 'Cuba','code' => 'cu'),
        //     array('id' => '47','title_ar' => 'الرأس الأخضر','title_en' => 'Cape Verde','code' => 'cv'),
        //     array('id' => '48','title_ar' => 'جزيرة الكريسماس','title_en' => 'Christmas Island','code' => 'cx'),
        //     array('id' => '49','title_ar' => 'قبرص','title_en' => 'Cyprus','code' => 'cy'),
        //     array('id' => '50','title_ar' => 'جمهورية التشيك','title_en' => 'Czech Republic','code' => 'cz'),
        //     array('id' => '51','title_ar' => 'ألمانيا','title_en' => 'Germany','code' => 'de'),
        //     array('id' => '52','title_ar' => 'جيبوتي','title_en' => 'Djibouti','code' => 'dj'),
        //     array('id' => '53','title_ar' => 'الدنمارك','title_en' => 'Denmark','code' => 'dk'),
        //     array('id' => '54','title_ar' => 'دومينيكا','title_en' => 'Dominica','code' => 'dm'),
        //     array('id' => '55','title_ar' => 'جمهورية الدومنيكان','title_en' => 'Dominican Republic','code' => 'do'),
        //     array('id' => '56','title_ar' => 'الجزائر','title_en' => 'Algeria','code' => 'dz'),
        //     array('id' => '57','title_ar' => 'الإكوادور','title_en' => 'Ecuador','code' => 'ec'),
        //     array('id' => '58','title_ar' => 'استونيا','title_en' => 'Estonia','code' => 'ee'),
        //     array('id' => '59','title_ar' => 'مصر','title_en' => 'Egypt','code' => 'eg'),
        //     array('id' => '60','title_ar' => 'الصحراء الغربية','title_en' => 'Western Sahara','code' => 'eh'),
        //     array('id' => '61','title_ar' => 'إريتريا','title_en' => 'Eritrea','code' => 'er'),
        //     array('id' => '62','title_ar' => 'إسبانيا','title_en' => 'Spain','code' => 'es'),
        //     array('id' => '63','title_ar' => 'أثيوبيا','title_en' => 'Ethiopia','code' => 'et'),
        //     array('id' => '64','title_ar' => 'فنلندا','title_en' => 'Finland','code' => 'fi'),
        //     array('id' => '65','title_ar' => 'فيجي','title_en' => 'Fiji','code' => 'fj'),
        //     array('id' => '66','title_ar' => 'جزر فوكلاند (مالفيناس)','title_en' => 'Falkland Islands (Malvinas)','code' => 'fk'),
        //     array('id' => '67','title_ar' => 'ولايات ميكرونيزيا الموحدة','title_en' => 'Federated States of Micronesia','code' => 'fm'),
        //     array('id' => '68','title_ar' => 'جزر صناعية','title_en' => 'Faroe Islands','code' => 'fo'),
        //     array('id' => '69','title_ar' => 'فرنسا','title_en' => 'France','code' => 'fr'),
        //     array('id' => '70','title_ar' => 'الغابون','title_en' => 'Gabon','code' => 'ga'),
        //     array('id' => '71','title_ar' => 'بريطانيا العظمى (المملكة المتحدة)','title_en' => 'Great Britain (UK)','code' => 'gb'),
        //     array('id' => '72','title_ar' => 'غرينادا','title_en' => 'Grenada','code' => 'gd'),
        //     array('id' => '73','title_ar' => 'جورجيا','title_en' => 'Georgia','code' => 'ge'),
        //     array('id' => '74','title_ar' => 'غيانا الفرنسية','title_en' => 'French Guiana','code' => 'gf'),
        //     array('id' => '76','title_ar' => 'غانا','title_en' => 'Ghana','code' => 'gh'),
        //     array('id' => '77','title_ar' => 'جبل طارق','title_en' => 'Gibraltar','code' => 'gi'),
        //     array('id' => '78','title_ar' => 'الأرض الخضراء','title_en' => 'Greenland','code' => 'gl'),
        //     array('id' => '79','title_ar' => 'غامبيا','title_en' => 'Gambia','code' => 'gm'),
        //     array('id' => '80','title_ar' => 'غينيا','title_en' => 'Guinea','code' => 'gn'),
        //     array('id' => '81','title_ar' => 'جوادلوب','title_en' => 'Guadeloupe','code' => 'gp'),
        //     array('id' => '82','title_ar' => 'غينيا الإستوائية','title_en' => 'Equatorial Guinea','code' => 'gq'),
        //     array('id' => '83','title_ar' => 'اليونان','title_en' => 'Greece','code' => 'gr'),
        //     array('id' => '84','title_ar' => 'جورجيا وجزر ساندويتش','title_en' => 'S. Georgia and S. Sandwich Islands','code' => 'gs'),
        //     array('id' => '85','title_ar' => 'غواتيمالا','title_en' => 'Guatemala','code' => 'gt'),
        //     array('id' => '86','title_ar' => 'غينيا بيساو','title_en' => 'Guinea-Bissau','code' => 'gw'),
        //     array('id' => '87','title_ar' => 'غيانا','title_en' => 'Guyana','code' => 'gy'),
        //     array('id' => '88','title_ar' => 'هونغ كونغ','title_en' => 'Hong Kong','code' => 'hk'),
        //     array('id' => '89','title_ar' => 'هندوراس','title_en' => 'Honduras','code' => 'hn'),
        //     array('id' => '90','title_ar' => 'كرواتيا (هرفاتسكا)','title_en' => 'Croatia (Hrvatska)','code' => 'hr'),
        //     array('id' => '91','title_ar' => 'هايتي','title_en' => 'Haiti','code' => 'ht'),
        //     array('id' => '92','title_ar' => 'اليونان','title_en' => 'Hungary','code' => 'hu'),
        //     array('id' => '93','title_ar' => 'أندونيسيا','title_en' => 'Indonesia','code' => 'id'),
        //     array('id' => '94','title_ar' => 'أيرلندا','title_en' => 'Ireland','code' => 'ie'),
        //     array('id' => '96','title_ar' => 'الهند','title_en' => 'India','code' => 'in'),
        //     array('id' => '97','title_ar' => 'العراق','title_en' => 'Iraq','code' => 'iq'),
        //     array('id' => '98','title_ar' => 'إيران','title_en' => 'Iran','code' => 'ir'),
        //     array('id' => '99','title_ar' => 'أيسلندا','title_en' => 'Iceland','code' => 'is'),
        //     array('id' => '100','title_ar' => 'إيطاليا','title_en' => 'Italy','code' => 'it'),
        //     array('id' => '101','title_ar' => 'جامايكا','title_en' => 'Jamaica','code' => 'jm'),
        //     array('id' => '102','title_ar' => 'الأردن','title_en' => 'Jordan','code' => 'jo'),
        //     array('id' => '103','title_ar' => 'اليابان','title_en' => 'Japan','code' => 'jp'),
        //     array('id' => '104','title_ar' => 'كينيا','title_en' => 'Kenya','code' => 'ke'),
        //     array('id' => '105','title_ar' => 'قرغيزستان','title_en' => 'Kyrgyzstan','code' => 'kg'),
        //     array('id' => '106','title_ar' => 'كمبوديا','title_en' => 'Cambodia','code' => 'kh'),
        //     array('id' => '107','title_ar' => 'كيريباس','title_en' => 'Kiribati','code' => 'ki'),
        //     array('id' => '108','title_ar' => 'جزر القمر','title_en' => 'Comoros','code' => 'km'),
        //     array('id' => '109','title_ar' => 'سانت كيتس ونيفيس','title_en' => 'Saint Kitts and Nevis','code' => 'kn'),
        //     array('id' => '110','title_ar' => 'كوريا الشمالية','title_en' => 'Korea (North)','code' => 'kp'),
        //     array('id' => '111','title_ar' => 'كوريا، جنوب)','title_en' => 'Korea (South)','code' => 'kr'),
        //     array('id' => '112','title_ar' => 'الكويت','title_en' => 'Kuwait','code' => 'kw'),
        //     array('id' => '113','title_ar' => 'جزر كايمان','title_en' => 'Cayman Islands','code' => 'ky'),
        //     array('id' => '114','title_ar' => 'كازاخستان','title_en' => 'Kazakhstan','code' => 'kz'),
        //     array('id' => '115','title_ar' => 'لاوس','title_en' => 'Laos','code' => 'la'),
        //     array('id' => '116','title_ar' => 'لبنان','title_en' => 'Lebanon','code' => 'lb'),
        //     array('id' => '117','title_ar' => 'القديسة لوسيا','title_en' => 'Saint Lucia','code' => 'lc'),
        //     array('id' => '118','title_ar' => 'ليختنشتاين','title_en' => 'Liechtenstein','code' => 'li'),
        //     array('id' => '119','title_ar' => 'سيريلانكا','title_en' => 'Sri Lanka','code' => 'lk'),
        //     array('id' => '120','title_ar' => 'ليبيريا','title_en' => 'Liberia','code' => 'lr'),
        //     array('id' => '121','title_ar' => 'ليسوتو','title_en' => 'Lesotho','code' => 'ls'),
        //     array('id' => '122','title_ar' => 'ليتوانيا','title_en' => 'Lithuania','code' => 'lt'),
        //     array('id' => '123','title_ar' => 'لوكسمبورغ','title_en' => 'Luxembourg','code' => 'lu'),
        //     array('id' => '124','title_ar' => 'لاتفيا','title_en' => 'Latvia','code' => 'lv'),
        //     array('id' => '125','title_ar' => 'ليبيا','title_en' => 'Libya','code' => 'ly'),
        //     array('id' => '126','title_ar' => 'المغرب','title_en' => 'Morocco','code' => 'ma'),
        //     array('id' => '127','title_ar' => 'موناكو','title_en' => 'Monaco','code' => 'mc'),
        //     array('id' => '128','title_ar' => 'مولدوفا','title_en' => 'Moldova','code' => 'md'),
        //     array('id' => '129','title_ar' => 'مدغشقر','title_en' => 'Madagascar','code' => 'mg'),
        //     array('id' => '130','title_ar' => 'جزر مارشال','title_en' => 'Marshall Islands','code' => 'mh'),
        //     array('id' => '131','title_ar' => 'مقدونيا','title_en' => 'Macedonia','code' => 'mk'),
        //     array('id' => '132','title_ar' => 'مالي','title_en' => 'Mali','code' => 'ml'),
        //     array('id' => '133','title_ar' => 'ميانمار','title_en' => 'Myanmar','code' => 'mm'),
        //     array('id' => '134','title_ar' => 'منغوليا','title_en' => 'Mongolia','code' => 'mn'),
        //     array('id' => '135','title_ar' => 'ماكاو','title_en' => 'Macao','code' => 'mo'),
        //     array('id' => '136','title_ar' => 'جزر مريانا الشمالية','title_en' => 'Northern Mariana Islands','code' => 'mp'),
        //     array('id' => '137','title_ar' => 'مارتينيك','title_en' => 'Martinique','code' => 'mq'),
        //     array('id' => '138','title_ar' => 'موريتانيا','title_en' => 'Mauritania','code' => 'mr'),
        //     array('id' => '139','title_ar' => 'مونتسيرات','title_en' => 'Montserrat','code' => 'ms'),
        //     array('id' => '140','title_ar' => 'مالطا','title_en' => 'Malta','code' => 'mt'),
        //     array('id' => '141','title_ar' => 'موريشيوس','title_en' => 'Mauritius','code' => 'mu'),
        //     array('id' => '142','title_ar' => 'جزر المالديف','title_en' => 'Maldives','code' => 'mv'),
        //     array('id' => '143','title_ar' => 'مالاوي','title_en' => 'Malawi','code' => 'mw'),
        //     array('id' => '144','title_ar' => 'المكسيك','title_en' => 'Mexico','code' => 'mx'),
        //     array('id' => '145','title_ar' => 'ماليزيا','title_en' => 'Malaysia','code' => 'my'),
        //     array('id' => '146','title_ar' => 'موزمبيق','title_en' => 'Mozambique','code' => 'mz'),
        //     array('id' => '147','title_ar' => 'ناميبيا','title_en' => 'Namibia','code' => 'na'),
        //     array('id' => '148','title_ar' => 'كاليدونيا الجديدة','title_en' => 'New Caledonia','code' => 'nc'),
        //     array('id' => '149','title_ar' => 'النيجر','title_en' => 'Niger','code' => 'ne'),
        //     array('id' => '150','title_ar' => 'جزيرة نورفولك','title_en' => 'Norfolk Island','code' => 'nf'),
        //     array('id' => '151','title_ar' => 'نيجيريا','title_en' => 'Nigeria','code' => 'ng'),
        //     array('id' => '152','title_ar' => 'نيكاراغوا','title_en' => 'Nicaragua','code' => 'ni'),
        //     array('id' => '153','title_ar' => 'هولندا','title_en' => 'Netherlands','code' => 'nl'),
        //     array('id' => '154','title_ar' => 'النرويج','title_en' => 'Norway','code' => 'no'),
        //     array('id' => '155','title_ar' => 'نيبال','title_en' => 'Nepal','code' => 'np'),
        //     array('id' => '156','title_ar' => 'ناورو','title_en' => 'Nauru','code' => 'nr'),
        //     array('id' => '157','title_ar' => 'نيوي','title_en' => 'Niue','code' => 'nu'),
        //     array('id' => '158','title_ar' => 'نيوزيلندا (اوتياروا)','title_en' => 'New Zealand (Aotearoa)','code' => 'nz'),
        //     array('id' => '159','title_ar' => 'سلطنة عمان','title_en' => 'Oman','code' => 'om'),
        //     array('id' => '160','title_ar' => 'بناما','title_en' => 'Panama','code' => 'pa'),
        //     array('id' => '161','title_ar' => 'بيرو','title_en' => 'Peru','code' => 'pe'),
        //     array('id' => '162','title_ar' => 'بولينيزيا الفرنسية','title_en' => 'French Polynesia','code' => 'pf'),
        //     array('id' => '163','title_ar' => 'بابوا غينيا الجديدة','title_en' => 'Papua New Guinea','code' => 'pg'),
        //     array('id' => '164','title_ar' => 'الفلبين','title_en' => 'Philippines','code' => 'ph'),
        //     array('id' => '165','title_ar' => 'باكستان','title_en' => 'Pakistan','code' => 'pk'),
        //     array('id' => '166','title_ar' => 'بولندا','title_en' => 'Poland','code' => 'pl'),
        //     array('id' => '167','title_ar' => 'سانت بيير وميكلون','title_en' => 'Saint Pierre and Miquelon','code' => 'pm'),
        //     array('id' => '168','title_ar' => 'بيتكيرن','title_en' => 'Pitcairn','code' => 'pn'),
        //     array('id' => '169','title_ar' => 'الأراضي الفلسطينية','title_en' => 'Palestinian Territory','code' => 'ps'),
        //     array('id' => '170','title_ar' => 'البرتغال','title_en' => 'Portugal','code' => 'pt'),
        //     array('id' => '171','title_ar' => 'بالاو','title_en' => 'Palau','code' => 'pw'),
        //     array('id' => '172','title_ar' => 'باراغواي','title_en' => 'Paraguay','code' => 'py'),
        //     array('id' => '173','title_ar' => 'دولة قطر','title_en' => 'Qatar','code' => 'qa'),
        //     array('id' => '174','title_ar' => 'جمع شمل','title_en' => 'Reunion','code' => 're'),
        //     array('id' => '175','title_ar' => 'رومانيا','title_en' => 'Romania','code' => 'ro'),
        //     array('id' => '176','title_ar' => 'الاتحاد الروسي','title_en' => 'Russian Federation','code' => 'ru'),
        //     array('id' => '177','title_ar' => 'رواندا','title_en' => 'Rwanda','code' => 'rw'),
        //     array('id' => '178','title_ar' => 'المملكة العربية السعودية','title_en' => 'Saudi Arabia','code' => 'sa'),
        //     array('id' => '179','title_ar' => 'جزر سليمان','title_en' => 'Solomon Islands','code' => 'sb'),
        //     array('id' => '180','title_ar' => 'سيشيل','title_en' => 'Seychelles','code' => 'sc'),
        //     array('id' => '181','title_ar' => 'سودان','title_en' => 'Sudan','code' => 'sd'),
        //     array('id' => '182','title_ar' => 'السويد','title_en' => 'Sweden','code' => 'se'),
        //     array('id' => '183','title_ar' => 'سنغافورة','title_en' => 'Singapore','code' => 'sg'),
        //     array('id' => '184','title_ar' => 'سانت هيلانة','title_en' => 'Saint Helena','code' => 'sh'),
        //     array('id' => '185','title_ar' => 'سلوفينيا','title_en' => 'Slovenia','code' => 'si'),
        //     array('id' => '186','title_ar' => 'سفالبارد وجان مايان','title_en' => 'Svalbard and Jan Mayen','code' => 'sj'),
        //     array('id' => '187','title_ar' => 'سلوفاكيا','title_en' => 'Slovakia','code' => 'sk'),
        //     array('id' => '188','title_ar' => 'سيرا ليون','title_en' => 'Sierra Leone','code' => 'sl'),
        //     array('id' => '189','title_ar' => 'سان مارينو','title_en' => 'San Marino','code' => 'sm'),
        //     array('id' => '190','title_ar' => 'السنغال','title_en' => 'Senegal','code' => 'sn'),
        //     array('id' => '191','title_ar' => 'الصومال','title_en' => 'Somalia','code' => 'so'),
        //     array('id' => '192','title_ar' => 'سورينام','title_en' => 'Surititlename','code' => 'sr'),
        //     array('id' => '193','title_ar' => 'ساو تومي وبرنسيبي','title_en' => 'Sao Tome and Principe','code' => 'st'),
        //     array('id' => '194','title_ar' => 'السلفادور','title_en' => 'El Salvador','code' => 'sv'),
        //     array('id' => '195','title_ar' => 'سوريا','title_en' => 'Syria','code' => 'sy'),
        //     array('id' => '196','title_ar' => 'سوازيلاند','title_en' => 'Swaziland','code' => 'sz'),
        //     array('id' => '197','title_ar' => 'جزر تركس وكايكوس','title_en' => 'Turks and Caicos Islands','code' => 'tc'),
        //     array('id' => '198','title_ar' => 'تشاد','title_en' => 'Chad','code' => 'td'),
        //     array('id' => '199','title_ar' => 'المناطق الجنوبية لفرنسا','title_en' => 'French Southern Territories','code' => 'tf'),
        //     array('id' => '200','title_ar' => 'ليذهب','title_en' => 'Togo','code' => 'tg'),
        //     array('id' => '201','title_ar' => 'تايلاند','title_en' => 'Thailand','code' => 'th'),
        //     array('id' => '202','title_ar' => 'طاجيكستان','title_en' => 'Tajikistan','code' => 'tj'),
        //     array('id' => '203','title_ar' => 'توكيلاو','title_en' => 'Tokelau','code' => 'tk'),
        //     array('id' => '204','title_ar' => 'تركمانستان','title_en' => 'Turkmenistan','code' => 'tm'),
        //     array('id' => '205','title_ar' => 'تونس','title_en' => 'Tunisia','code' => 'tn'),
        //     array('id' => '206','title_ar' => 'تونغا','title_en' => 'Tonga','code' => 'to'),
        //     array('id' => '207','title_ar' => 'تركيا','title_en' => 'Turkey','code' => 'tr'),
        //     array('id' => '208','title_ar' => 'ترينداد وتوباغو','title_en' => 'Trinidad and Tobago','code' => 'tt'),
        //     array('id' => '209','title_ar' => 'توفالو','title_en' => 'Tuvalu','code' => 'tv'),
        //     array('id' => '210','title_ar' => 'تايوان','title_en' => 'Taiwan','code' => 'tw'),
        //     array('id' => '211','title_ar' => 'تنزانيا','title_en' => 'Tanzania','code' => 'tz'),
        //     array('id' => '212','title_ar' => 'أوكرانيا','title_en' => 'Ukraine','code' => 'ua'),
        //     array('id' => '213','title_ar' => 'أوغندا','title_en' => 'Uganda','code' => 'ug'),
        //     array('id' => '214','title_ar' => 'أوروغواي','title_en' => 'Uruguay','code' => 'uy'),
        //     array('id' => '215','title_ar' => 'أوزبكستان','title_en' => 'Uzbekistan','code' => 'uz'),
        //     array('id' => '216','title_ar' => 'سانت فنسنت وجزر غرينادين','title_en' => 'Saint Vincent and the Grenadines','code' => 'vc'),
        //     array('id' => '217','title_ar' => 'فنزويلا','title_en' => 'Venezuela','code' => 've'),
        //     array('id' => '218','title_ar' => 'جزر العذراء البريطانية)','title_en' => 'Virgin Islands (British)','code' => 'vg'),
        //     array('id' => '219','title_ar' => 'جزر فيرجن (الولايات المتحدة)','title_en' => 'Virgin Islands (U.S.)','code' => 'vi'),
        //     array('id' => '220','title_ar' => 'فيتنام','title_en' => 'Viet Nam','code' => 'vn'),
        //     array('id' => '221','title_ar' => 'فانواتو','title_en' => 'Vanuatu','code' => 'vu'),
        //     array('id' => '222','title_ar' => 'واليس وفوتونا','title_en' => 'Wallis and Futuna','code' => 'wf'),
        //     array('id' => '223','title_ar' => 'ساموا','title_en' => 'Samoa','code' => 'ws'),
        //     array('id' => '224','title_ar' => 'اليمن','title_en' => 'Yemen','code' => 'ye'),
        //     array('id' => '225','title_ar' => 'مايوت','title_en' => 'Mayotte','code' => 'yt'),
        //     array('id' => '226','title_ar' => 'جنوب أفريقيا','title_en' => 'South Africa','code' => 'za'),
        //     array('id' => '227','title_ar' => 'زامبيا','title_en' => 'Zambia','code' => 'zm'),
        //     array('id' => '228','title_ar' => 'زائير (سابقة)','title_en' => 'Zaire (former)','code' => 'zr'),
        //     array('id' => '229','title_ar' => 'زيمبابوي','title_en' => 'Zimbabwe','code' => 'zw'),
        //     array('id' => '230','title_ar' => 'الولايات المتحدة','title_en' => 'United States of America','code' => 'us'),
        //     ];

        // DB::table('countries')->insert($countries);

        $countries = [];
        $response = Http::get('https://restcountries.com/v3.1/all');
        if ($response->successful()) {
            $data = json_decode($response->getBody()->getContents(),true);
            foreach ($data as $country) {
                if($country['name']['common'] !== 'Israel'      ||
                   $country['name']['common'] !== 'Belarus'     ||
                   $country['name']['common'] !== 'Cuba'        ||
                   $country['name']['common'] !== 'Eritrea'     ||
                   $country['name']['common'] !== 'Iran'        ||
                   $country['name']['common'] !== 'North Korea' ||
                   $country['name']['common'] !== 'Syria'       ||
                   $country['name']['common'] !== 'Venezuela'){

                    $result = [];
                    $result['title_en'] = $country['name']['common'];
                    $result['title_ar'] = $country['translations']['ara']['common'];
                    $result['code'] = $country['cca2'];
                    $result['flag'] = $country['flags']['svg'];

                    if ( $country['idd'] !== [] ){
                        $phone_prefixes = [];
                        foreach ($country['idd']['suffixes'] as $suffix) {
                            $phone_prefixes[] = $country['idd']['root'] . $suffix;
                            $result['phone_prefixes'] = $phone_prefixes;
                        }
                        $result['phone_prefixes'] = json_encode($result['phone_prefixes']);
                    }
                    else {
                        $result['phone_prefixes'] = null;
                    }

                    $countries[] = $result;
                }

            }
        }
        DB::table('countries')->insert($countries);

    }
}
