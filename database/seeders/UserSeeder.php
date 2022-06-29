<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [1, 'Havind',   'Ali',          'havind.ali',       0, 'havindali@gmail.com',       'hali@care.de',         '964 750 414 1973', null,               34, 0, 22, 1, 'drupal', 1],
            [2, 'Ahmed',    'Abdulazeez',   'ahmed.abdulazeez', 0, null,                        'abdulazeez@care.de',   '964 751 745 1811', null,               34, 0, 23, 1, 'drupal', 1],
            [3, 'Luma',     'Abdullah',     'luma.abdullah',    0, null,                        'abdullah@care.de',     null,               '964 751 800 2957', 0,  0, 31, 0, 'drupal', 0],
            [4, 'Sabhan',   'Abody',        'sabhan.abody',     0, null,                        'abody@care.de',        '964 751 144 7218', '964 751 800 1153', 0,  0, 11, 0, 'drupal', 0],
            [5, 'Wakeel',   'Ahmad',        'wakeel.ahmad',     0, null,                        'wahmad@care.de',       '964 751 741 4258', null,               0,  0, 35, 6, 'drupal', 1],
            [6, 'Nechirvan','Ahmed',        'nechirvan.ahmed',  0, null,                        'abed@care.de',         '964 750 372 3088', null,               42, 0, 10, 5, 'drupal', 1],
            [7, 'Salam',    'Ahmed',        'salam.ahmed',      0, null,                        'salamahmed@care.de',   '964 751 800 2963', null,               34, 0,  2, 1, 'drupal', 1],
            [8, 'Noor',     'Ahmed',        'noor.ahmed',       0, null,                        'ahmed@care.de',        '964 751 745 1821', null,               0,  0, 34, 0, 'drupal', 0],
            [9, 'Ameer',    'Ahmed',        'ameer.ahmed',      0, null,                        'luqman@care.de',       '964 750 456 1497', null,               27, 0,  7, 2, 'drupal', 0],
            [10, 'Eman',    'Alazzawi',     'eman.alazzawi',    0, null,                        'hameed@care.de',       '964 790 156 2174', null,               0,  0,  4, 0, 'drupal', 0],
            [11, 'Amad',    'Ali',          'amad.ali',         0, null,                        'amad.ali@care.de',     '964 750 402 7485', '964 751 800 1151', 14, 0, 13, 9, 'drupal', 1],
            [12, 'Huda',    'Ali',          'huda.ali',         0, null,                        'hudaali@care.de',      '964 783 009 5297', '964 751 800 1138', 44, 0, 28, 7, 'drupal', 1],
            [13, 'Sibar',   'Arab',         'sibar.arab',       0, null,                        'bilal@care.de',        null,               '964 751 800 1141', 0,  0, 21, 0, 'drupal', 0],
            [14, 'Cansu',   'Aydin',        'cansu.aydin',      0, null,                        'aydin@care.de',        '964 751 741 4395', null,               0,  0, 12, 9, 'drupal', 0],
            [15, 'Saud',    'Azdin',        'saud.azdin',       0, null,                        'azdin@care.de',        '964 751 848 2312', null,               0,  0, 24, 0, 'drupal', 0],
            [16, 'Bishar',  'Bakir',        'bishar.bakir',     0, null,                        'bbaker@care.de',       '964 750 321 2612', null,               34, 0, 23, 1, 'drupal', 0],
            [17, 'Wendy',   'Barron',       'wendy.barron',     0, null,                        'barron@care.de',       '964 750 335 4239', null,               0,  0,  6, 4, 'drupal', 0],
            [18, 'Dunia',   'Dakheel',      'dunia.dakheel',    0, null,                        'dakheel@care.de',      '964 750 773 6813', '964 751 800 1152', 0,  0, 11, 0, 'drupal', 0],
            [19, 'Zainab',  'Fathel',       'zainab.fathel',    0, null,                        'fathel@care.de',       '964 751 042 6370', '964 751 163 7552', 0,  0, 29, 0, 'drupal', 0],
            [20, 'Nizhyar', 'Haji',         'nizhyar.haji',     0, null,                        'nmirza@care.de',       '964 750 486 7175', null,               17, 0, 19, 3, 'drupal', 1],
            [21, 'Khalid',  'Haji',         'khalid.haji',      0, null,                        'haji@care.de',         '964 750 332 8278', null,               34, 0,  2, 1, 'drupal', 0],
            [22, 'Lawin',   'Haji',         'lawin.haji',       0, null,                        'driver1-iraq@care.de', '964 750 473 9802', null,               27, 0,  7, 2, 'drupal', 0],
            [23, 'Dilman',  'Hameed',       'dilman.hameed',    0, null,                        'amo@care.de',          '964 750 439 9521', null,               35, 0, 25, 8, 'drupal', 0],
            [24, 'Ghaida',  'Hassan',       'ghaida.hassan',    0, null,                        'hasan@care.de',        null,               '964 751 800 1157', 44, 0, 16, 7, 'drupal', 1],
            [25, 'Showan',  'Hassan',       'showan.hassan',    0, null,                        'shassan@care.de',      '964 750 168 6199', '964 750 878 6972', 0,  0, 34, 0, 'drupal', 0],
            [26, 'Roj',     'Haydar',       'roj.haydar',       0, null,                        'haydar@care.de',       '964 750 484 6219', '964 751 800 1158', 23, 0, 24, 8, 'drupal', 1],
            [27, 'Zirak',   'Hussein',      'zirak.hussein',    0, null,                        'abdulqadir@care.de',   '964 751 538 4064', null,               47, 0, 33, 2, 'drupal', 1],
            [28, 'Yaseen',  'Jassim',       'yaseen.jassim',    0, null,                        'jassim@care.de',       '964 751 800 2960', null,               0,  0, 36, 0, 'drupal', 0],
            [29, 'Sita',    'Jojan',        'sita.jojan',       0, null,                        'jojan@care.de',        null,               '964 751 800 1160', 0,  0, 15, 0, 'drupal', 1],
            [30, 'Hiyam',   'Khalaf',       'hiyam.khalaf',     0, null,                        null,                   '964 750 894 3493', null,               0,  0, 20, 0, 'drupal', 0],
            [31, 'Dildar',  'Khawaja',      'dildar.khawaja',   0, null,                        'khawaja@care.de',      '964 780 707 0976', '964 751 745 1804', 0,  0, 38, 0, 'drupal', 0],
            [32, 'Hiba',    'Khudhur',      'hiba.khudhur',     0, null,                        'khudhur@care.de',      '964 770 636 1633', '964 751 800 1137', 0,  0, 24, 0, 'drupal', 0],
            [33, 'Randa',   'Kicho',        'randa.kicho',      0, null,                        'kicho@care.de',        '964 751 789 4978', '964 751 800 1139', 0,  0, 11, 9, 'drupal', 0],
            [34, 'Meera',   'Majithia',     'meera.majithia',   0, null,                        'majithia@care.de',     null,               '964 751 745 1814', 17, 0,  3, 1, 'drupal', 1],
            [35, 'Emebet',  'Menna',        'emebet.menna',     0, null,                        'emenna@care.de',       null,               '964 751 745 1361', 0,  0, 30, 0, 'drupal', 0],
            [36, 'Payman',  'Mobarak',      'payman.mobarak',   0, null,                        'mahmood@care.de',      null,               '964 751 745 1802', 0,  0, 37, 6, 'drupal', 0],
            [37, 'Karveen', 'Mohammed',     'karveen.mohammed', 0, null,                        'kmohammed@care.de',    '964 751 836 4663', null,               0,  0, 1, 10, 'drupal', 1],
            [38, 'Sundis',  'Mohammed',     'sundis.mohammed',  0, null,                        'smohammed@care.de',    '964 750 432 7487', null,               42, 0,  8, 5, 'drupal', 0],
            [39, 'Rahma',   'Mohammed',     'rahma.mohammed',   0, null,                        'rmohammed@care.de',    '964 750 214 7543', '964 751 800 1154', 0,  0,  5, 0, 'drupal', 0],
            [40, 'Idris',   'Omar',         'idris.omar',       0, null,                        'driver2-iraq@care.de', '964 750 135 5150', null,               27, 0,  7, 2, 'drupal', 0],
            [41, 'Kameran', 'Sadiq',        'kameran.sadiq',    0, null,                        'sadeeq@care.de',       '964 750 759 8200', null,               34, 0, 27, 1, 'drupal', 1],
            [42, 'Ali',     'Safwat',       'ali.safwat',       0, null,                        'safwat@care.de',       '964 750 420 9251', null,               17, 0,  9, 5, 'drupal', 1],
            [43, 'Kavi',    'Saifadeen',    'kavi.saifadeen',   0, null,                        'saifadeen@care.de',    '964 750 459 8624', null,               23, 0, 26, 8, 'drupal', 1],
            [44, 'Omer',    'Saleh',        'omer.saleh',       0, null,                        'omar.saleh@care.de',   '964 751 745 1819', null,               0,  0, 17, 7, 'drupal', 1],
            [45, 'Randi',   'Shabo',        'randi.shabo',      0, null,                        'shabo@care.de',        '964 750 406 1757', '964 751 741 4263', 20, 0, 18, 3, 'drupal', 0],
            [46, 'Anfal',   'Sultan',       'anfal.sultan',     0, null,                        'sultan@care.de',       '964 750 878 6974', null,               0,  0, 11, 0, 'drupal', 0],
            [47, 'Roj',     'Shaaban',      'roj.shaaban',      0, null,                        'shaaban@care.de',      '964 751 224 7254', '964 751 058 0374', 17, 0, 32, 2, 'drupal', 1],
            [48, 'Kamal',   'Zilfo',        'kamal.zilfo',      0, 'alzilfokamal@gmail.com',    null,                   '964 780 629 8760', '964 750 893 1361', 0,  0, 20, 0, 'drupal', 0],
        ];
        foreach ($data as $datum) {
            User::insert([
                'id' => $datum[0],
                'first_name' => $datum[1],
                'last_name' => $datum[2],
                'username' => $datum[3],
                'role_id' => $datum[4],
                'personal_email' => $datum[5],
                'work_email' => $datum[6],
                'personal_phone' => $datum[7],
                'work_phone' => $datum[8],
                'supervisor_id' => $datum[9],
                'acting_supervisor_id' => $datum[10],
                'position_id' => $datum[11],
                'department_id' => $datum[12],
                'password' => bcrypt($datum[13]),
                'created_at' => now(),
            ]);
        }
    }
}
