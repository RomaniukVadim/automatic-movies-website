<?php

class td_fonts {


    //font stacks
    static $font_stack_list = array(
        'fs_1' => 'Verdana, Geneva, sans-serif',
        'fs_2' => '"Helvetica Neue", Helvetica, Arial, sans-serif',
        'fs_3' => 'Baskerville, "Times New Roman", Times, serif',
        'fs_4' => 'Garamond, "Hoefler Text", "Times New Roman", Times, serif',
        'fs_5' => 'Geneva, "Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", Verdana, sans-serif',
        'fs_6' => 'GillSans, Calibri, Trebuchet, sans-serif',
        'fs_7' => 'Georgia, Times, "Times New Roman", serif',
        'fs_8' => 'Palatino, "Palatino Linotype", "Hoefler Text", Times, "Times New Roman", serif',
        'fs_9' => 'Tahoma, Verdana, Geneva',
        'fs_10' => 'Trebuchet, Tahoma, Arial, sans-serif',
    );


    //google fonts
    static $font_names_google_list = array (
        1 => 'ABeeZee',
        2 => 'Abel',
        3 => 'Abril Fatface',
        4 => 'Aclonica',
        5 => 'Acme',
        6 => 'Actor',
        7 => 'Adamina',
        8 => 'Advent Pro',
        9 => 'Aguafina Script',
        10 => 'Akronim',
        11 => 'Aladin',
        12 => 'Aldrich',
        13 => 'Alef',
        14 => 'Alegreya',
        15 => 'Alegreya SC',
        16 => 'Alex Brush',
        17 => 'Alfa Slab One',
        18 => 'Alice',
        19 => 'Alike',
        20 => 'Alike Angular',
        21 => 'Allan',
        22 => 'Allerta',
        23 => 'Allerta Stencil',
        24 => 'Allura',
        25 => 'Almendra',
        26 => 'Almendra Display',
        27 => 'Almendra SC',
        28 => 'Amarante',
        29 => 'Amaranth',
        30 => 'Amatic SC',
        31 => 'Amethysta',
        32 => 'Anaheim',
        33 => 'Andada',
        34 => 'Andika',
        35 => 'Angkor',
        36 => 'Annie Use Your Telescope',
        37 => 'Anonymous Pro',
        38 => 'Antic',
        39 => 'Antic Didone',
        40 => 'Antic Slab',
        41 => 'Anton',
        42 => 'Arapey',
        43 => 'Arbutus',
        44 => 'Arbutus Slab',
        45 => 'Architects Daughter',
        46 => 'Archivo Black',
        47 => 'Archivo Narrow',
        48 => 'Arimo',
        49 => 'Arizonia',
        50 => 'Armata',
        51 => 'Artifika',
        52 => 'Arvo',
        53 => 'Asap',
        54 => 'Asset',
        55 => 'Astloch',
        56 => 'Asul',
        57 => 'Atomic Age',
        58 => 'Aubrey',
        59 => 'Audiowide',
        60 => 'Autour One',
        61 => 'Average',
        62 => 'Average Sans',
        63 => 'Averia Gruesa Libre',
        64 => 'Averia Libre',
        65 => 'Averia Sans Libre',
        66 => 'Averia Serif Libre',
        67 => 'Bad Script',
        68 => 'Balthazar',
        69 => 'Bangers',
        70 => 'Basic',
        71 => 'Battambang',
        72 => 'Baumans',
        73 => 'Bayon',
        74 => 'Belgrano',
        75 => 'Belleza',
        76 => 'BenchNine',
        77 => 'Bentham',
        78 => 'Berkshire Swash',
        79 => 'Bevan',
        80 => 'Bigelow Rules',
        81 => 'Bigshot One',
        82 => 'Bilbo',
        83 => 'Bilbo Swash Caps',
        84 => 'Bitter',
        85 => 'Black Ops One',
        86 => 'Bokor',
        87 => 'Bonbon',
        88 => 'Boogaloo',
        89 => 'Bowlby One',
        90 => 'Bowlby One SC',
        91 => 'Brawler',
        92 => 'Bree Serif',
        93 => 'Bubblegum Sans',
        94 => 'Bubbler One',
        95 => 'Buda',
        96 => 'Buenard',
        97 => 'Butcherman',
        98 => 'Butterfly Kids',
        99 => 'Cabin',
        100 => 'Cabin Condensed',
        101 => 'Cabin Sketch',
        102 => 'Caesar Dressing',
        103 => 'Cagliostro',
        104 => 'Calligraffitti',
        105 => 'Cambo',
        106 => 'Candal',
        107 => 'Cantarell',
        108 => 'Cantata One',
        109 => 'Cantora One',
        110 => 'Capriola',
        111 => 'Cardo',
        112 => 'Carme',
        113 => 'Carrois Gothic',
        114 => 'Carrois Gothic SC',
        115 => 'Carter One',
        116 => 'Caudex',
        117 => 'Cedarville Cursive',
        118 => 'Ceviche One',
        119 => 'Changa One',
        120 => 'Chango',
        121 => 'Chau Philomene One',
        122 => 'Chela One',
        123 => 'Chelsea Market',
        124 => 'Chenla',
        125 => 'Cherry Cream Soda',
        126 => 'Cherry Swash',
        127 => 'Chewy',
        128 => 'Chicle',
        129 => 'Chivo',
        130 => 'Cinzel',
        131 => 'Cinzel Decorative',
        132 => 'Clicker Script',
        133 => 'Coda',
        134 => 'Coda Caption',
        135 => 'Codystar',
        136 => 'Combo',
        137 => 'Comfortaa',
        138 => 'Coming Soon',
        139 => 'Concert One',
        140 => 'Condiment',
        141 => 'Content',
        142 => 'Contrail One',
        143 => 'Convergence',
        144 => 'Cookie',
        145 => 'Copse',
        146 => 'Corben',
        147 => 'Courgette',
        148 => 'Cousine',
        149 => 'Coustard',
        150 => 'Covered By Your Grace',
        151 => 'Crafty Girls',
        152 => 'Creepster',
        153 => 'Crete Round',
        154 => 'Crimson Text',
        155 => 'Croissant One',
        156 => 'Crushed',
        157 => 'Cuprum',
        158 => 'Cutive',
        159 => 'Cutive Mono',
        160 => 'Damion',
        161 => 'Dancing Script',
        162 => 'Dangrek',
        163 => 'Dawning of a New Day',
        164 => 'Days One',
        165 => 'Delius',
        166 => 'Delius Swash Caps',
        167 => 'Delius Unicase',
        168 => 'Della Respira',
        169 => 'Denk One',
        170 => 'Devonshire',
        171 => 'Didact Gothic',
        172 => 'Diplomata',
        173 => 'Diplomata SC',
        174 => 'Domine',
        175 => 'Donegal One',
        176 => 'Doppio One',
        177 => 'Dorsa',
        178 => 'Dosis',
        179 => 'Dr Sugiyama',
        180 => 'Droid Sans',
        181 => 'Droid Sans Mono',
        182 => 'Droid Serif',
        183 => 'Duru Sans',
        184 => 'Dynalight',
        185 => 'EB Garamond',
        186 => 'Eagle Lake',
        187 => 'Eater',
        188 => 'Economica',
        189 => 'Electrolize',
        190 => 'Elsie',
        191 => 'Elsie Swash Caps',
        192 => 'Emblema One',
        193 => 'Emilys Candy',
        194 => 'Engagement',
        195 => 'Englebert',
        196 => 'Enriqueta',
        197 => 'Erica One',
        198 => 'Esteban',
        199 => 'Euphoria Script',
        200 => 'Ewert',
        201 => 'Exo',
        202 => 'Expletus Sans',
        203 => 'Fanwood Text',
        204 => 'Fascinate',
        205 => 'Fascinate Inline',
        206 => 'Faster One',
        207 => 'Fasthand',
        208 => 'Fauna One',
        209 => 'Federant',
        210 => 'Federo',
        211 => 'Felipa',
        212 => 'Fenix',
        213 => 'Finger Paint',
        214 => 'Fjalla One',
        215 => 'Fjord One',
        216 => 'Flamenco',
        217 => 'Flavors',
        218 => 'Fondamento',
        219 => 'Fontdiner Swanky',
        220 => 'Forum',
        221 => 'Francois One',
        222 => 'Freckle Face',
        223 => 'Fredericka the Great',
        224 => 'Fredoka One',
        225 => 'Freehand',
        226 => 'Fresca',
        227 => 'Frijole',
        228 => 'Fruktur',
        229 => 'Fugaz One',
        230 => 'GFS Didot',
        231 => 'GFS Neohellenic',
        232 => 'Gabriela',
        233 => 'Gafata',
        234 => 'Galdeano',
        235 => 'Galindo',
        236 => 'Gentium Basic',
        237 => 'Gentium Book Basic',
        238 => 'Geo',
        239 => 'Geostar',
        240 => 'Geostar Fill',
        241 => 'Germania One',
        242 => 'Gilda Display',
        243 => 'Give You Glory',
        244 => 'Glass Antiqua',
        245 => 'Glegoo',
        246 => 'Gloria Hallelujah',
        247 => 'Goblin One',
        248 => 'Gochi Hand',
        249 => 'Gorditas',
        250 => 'Goudy Bookletter 1911',
        251 => 'Graduate',
        252 => 'Grand Hotel',
        253 => 'Gravitas One',
        254 => 'Great Vibes',
        255 => 'Griffy',
        256 => 'Gruppo',
        257 => 'Gudea',
        258 => 'Habibi',
        259 => 'Hammersmith One',
        260 => 'Hanalei',
        261 => 'Hanalei Fill',
        262 => 'Handlee',
        263 => 'Hanuman',
        264 => 'Happy Monkey',
        265 => 'Headland One',
        266 => 'Henny Penny',
        267 => 'Herr Von Muellerhoff',
        268 => 'Holtwood One SC',
        269 => 'Homemade Apple',
        270 => 'Homenaje',
        271 => 'IM Fell DW Pica',
        272 => 'IM Fell DW Pica SC',
        273 => 'IM Fell Double Pica',
        274 => 'IM Fell Double Pica SC',
        275 => 'IM Fell English',
        276 => 'IM Fell English SC',
        277 => 'IM Fell French Canon',
        278 => 'IM Fell French Canon SC',
        279 => 'IM Fell Great Primer',
        280 => 'IM Fell Great Primer SC',
        281 => 'Iceberg',
        282 => 'Iceland',
        283 => 'Imprima',
        284 => 'Inconsolata',
        285 => 'Inder',
        286 => 'Indie Flower',
        287 => 'Inika',
        288 => 'Irish Grover',
        289 => 'Istok Web',
        290 => 'Italiana',
        291 => 'Italianno',
        292 => 'Jacques Francois',
        293 => 'Jacques Francois Shadow',
        294 => 'Jim Nightshade',
        295 => 'Jockey One',
        296 => 'Jolly Lodger',
        297 => 'Josefin Sans',
        298 => 'Josefin Slab',
        299 => 'Joti One',
        300 => 'Judson',
        301 => 'Julee',
        302 => 'Julius Sans One',
        303 => 'Junge',
        304 => 'Jura',
        305 => 'Just Another Hand',
        306 => 'Just Me Again Down Here',
        307 => 'Kameron',
        308 => 'Karla',
        309 => 'Kaushan Script',
        310 => 'Kavoon',
        311 => 'Keania One',
        312 => 'Kelly Slab',
        313 => 'Kenia',
        314 => 'Khmer',
        315 => 'Kite One',
        316 => 'Knewave',
        317 => 'Kotta One',
        318 => 'Koulen',
        319 => 'Kranky',
        320 => 'Kreon',
        321 => 'Kristi',
        322 => 'Krona One',
        323 => 'La Belle Aurore',
        324 => 'Lancelot',
        325 => 'Lato',
        326 => 'League Script',
        327 => 'Leckerli One',
        328 => 'Ledger',
        329 => 'Lekton',
        330 => 'Lemon',
        331 => 'Libre Baskerville',
        332 => 'Life Savers',
        333 => 'Lilita One',
        334 => 'Lily Script One',
        335 => 'Limelight',
        336 => 'Linden Hill',
        337 => 'Lobster',
        338 => 'Lobster Two',
        339 => 'Londrina Outline',
        340 => 'Londrina Shadow',
        341 => 'Londrina Sketch',
        342 => 'Londrina Solid',
        343 => 'Lora',
        344 => 'Love Ya Like A Sister',
        345 => 'Loved by the King',
        346 => 'Lovers Quarrel',
        347 => 'Luckiest Guy',
        348 => 'Lusitana',
        349 => 'Lustria',
        350 => 'Macondo',
        351 => 'Macondo Swash Caps',
        352 => 'Magra',
        353 => 'Maiden Orange',
        354 => 'Mako',
        355 => 'Marcellus',
        356 => 'Marcellus SC',
        357 => 'Marck Script',
        358 => 'Margarine',
        359 => 'Marko One',
        360 => 'Marmelad',
        361 => 'Marvel',
        362 => 'Mate',
        363 => 'Mate SC',
        364 => 'Maven Pro',
        365 => 'McLaren',
        366 => 'Meddon',
        367 => 'MedievalSharp',
        368 => 'Medula One',
        369 => 'Megrim',
        370 => 'Meie Script',
        371 => 'Merienda',
        372 => 'Merienda One',
        373 => 'Merriweather',
        374 => 'Merriweather Sans',
        375 => 'Metal',
        376 => 'Metal Mania',
        377 => 'Metamorphous',
        378 => 'Metrophobic',
        379 => 'Michroma',
        380 => 'Milonga',
        381 => 'Miltonian',
        382 => 'Miltonian Tattoo',
        383 => 'Miniver',
        384 => 'Miss Fajardose',
        385 => 'Modern Antiqua',
        386 => 'Molengo',
        387 => 'Molle',
        388 => 'Monda',
        389 => 'Monofett',
        390 => 'Monoton',
        391 => 'Monsieur La Doulaise',
        392 => 'Montaga',
        393 => 'Montez',
        394 => 'Montserrat',
        395 => 'Montserrat Alternates',
        396 => 'Montserrat Subrayada',
        397 => 'Moul',
        398 => 'Moulpali',
        399 => 'Mountains of Christmas',
        400 => 'Mouse Memoirs',
        401 => 'Mr Bedfort',
        402 => 'Mr Dafoe',
        403 => 'Mr De Haviland',
        404 => 'Mrs Saint Delafield',
        405 => 'Mrs Sheppards',
        406 => 'Muli',
        407 => 'Mystery Quest',
        408 => 'Neucha',
        409 => 'Neuton',
        410 => 'New Rocker',
        411 => 'News Cycle',
        412 => 'Niconne',
        413 => 'Nixie One',
        414 => 'Nobile',
        415 => 'Nokora',
        416 => 'Norican',
        417 => 'Nosifer',
        418 => 'Nothing You Could Do',
        419 => 'Noticia Text',
        420 => 'Noto Sans',
        421 => 'Noto Serif',
        422 => 'Nova Cut',
        423 => 'Nova Flat',
        424 => 'Nova Mono',
        425 => 'Nova Oval',
        426 => 'Nova Round',
        427 => 'Nova Script',
        428 => 'Nova Slim',
        429 => 'Nova Square',
        430 => 'Numans',
        431 => 'Nunito',
        432 => 'Odor Mean Chey',
        433 => 'Offside',
        434 => 'Old Standard TT',
        435 => 'Oldenburg',
        436 => 'Oleo Script',
        437 => 'Oleo Script Swash Caps',
        438 => 'Open Sans',
        439 => 'Open Sans Condensed',
        440 => 'Oranienbaum',
        441 => 'Orbitron',
        442 => 'Oregano',
        443 => 'Orienta',
        444 => 'Original Surfer',
        445 => 'Oswald',
        446 => 'Over the Rainbow',
        447 => 'Overlock',
        448 => 'Overlock SC',
        449 => 'Ovo',
        450 => 'Oxygen',
        451 => 'Oxygen Mono',
        452 => 'PT Mono',
        453 => 'PT Sans',
        454 => 'PT Sans Caption',
        455 => 'PT Sans Narrow',
        456 => 'PT Serif',
        457 => 'PT Serif Caption',
        458 => 'Pacifico',
        459 => 'Paprika',
        460 => 'Parisienne',
        461 => 'Passero One',
        462 => 'Passion One',
        463 => 'Pathway Gothic One',
        464 => 'Patrick Hand',
        465 => 'Patrick Hand SC',
        466 => 'Patua One',
        467 => 'Paytone One',
        468 => 'Peralta',
        469 => 'Permanent Marker',
        470 => 'Petit Formal Script',
        471 => 'Petrona',
        472 => 'Philosopher',
        473 => 'Piedra',
        474 => 'Pinyon Script',
        475 => 'Pirata One',
        476 => 'Plaster',
        477 => 'Play',
        478 => 'Playball',
        479 => 'Playfair Display',
        480 => 'Playfair Display SC',
        481 => 'Podkova',
        482 => 'Poiret One',
        483 => 'Poller One',
        484 => 'Poly',
        485 => 'Pompiere',
        486 => 'Pontano Sans',
        487 => 'Port Lligat Sans',
        488 => 'Port Lligat Slab',
        489 => 'Prata',
        490 => 'Preahvihear',
        491 => 'Press Start 2P',
        492 => 'Princess Sofia',
        493 => 'Prociono',
        494 => 'Prosto One',
        495 => 'Puritan',
        496 => 'Purple Purse',
        497 => 'Quando',
        498 => 'Quantico',
        499 => 'Quattrocento',
        500 => 'Quattrocento Sans',
        501 => 'Questrial',
        502 => 'Quicksand',
        503 => 'Quintessential',
        504 => 'Qwigley',
        505 => 'Racing Sans One',
        506 => 'Radley',
        507 => 'Raleway',
        508 => 'Raleway Dots',
        509 => 'Rambla',
        510 => 'Rammetto One',
        511 => 'Ranchers',
        512 => 'Rancho',
        513 => 'Rationale',
        514 => 'Redressed',
        515 => 'Reenie Beanie',
        516 => 'Revalia',
        517 => 'Ribeye',
        518 => 'Ribeye Marrow',
        519 => 'Righteous',
        520 => 'Risque',
        521 => 'Roboto',
        522 => 'Roboto Condensed',
        523 => 'Roboto Slab',
        524 => 'Rochester',
        525 => 'Rock Salt',
        526 => 'Rokkitt',
        527 => 'Romanesco',
        528 => 'Ropa Sans',
        529 => 'Rosario',
        530 => 'Rosarivo',
        531 => 'Rouge Script',
        532 => 'Ruda',
        533 => 'Rufina',
        534 => 'Ruge Boogie',
        535 => 'Ruluko',
        536 => 'Rum Raisin',
        537 => 'Ruslan Display',
        538 => 'Russo One',
        539 => 'Ruthie',
        540 => 'Rye',
        541 => 'Sacramento',
        542 => 'Sail',
        543 => 'Salsa',
        544 => 'Sanchez',
        545 => 'Sancreek',
        546 => 'Sansita One',
        547 => 'Sarina',
        548 => 'Satisfy',
        549 => 'Scada',
        550 => 'Schoolbell',
        551 => 'Seaweed Script',
        552 => 'Sevillana',
        553 => 'Seymour One',
        554 => 'Shadows Into Light',
        555 => 'Shadows Into Light Two',
        556 => 'Shanti',
        557 => 'Share',
        558 => 'Share Tech',
        559 => 'Share Tech Mono',
        560 => 'Shojumaru',
        561 => 'Short Stack',
        562 => 'Siemreap',
        563 => 'Sigmar One',
        564 => 'Signika',
        565 => 'Signika Negative',
        566 => 'Simonetta',
        567 => 'Sintony',
        568 => 'Sirin Stencil',
        569 => 'Six Caps',
        570 => 'Skranji',
        571 => 'Slackey',
        572 => 'Smokum',
        573 => 'Smythe',
        574 => 'Sniglet',
        575 => 'Snippet',
        576 => 'Snowburst One',
        577 => 'Sofadi One',
        578 => 'Sofia',
        579 => 'Sonsie One',
        580 => 'Sorts Mill Goudy',
        581 => 'Source Code Pro',
        582 => 'Source Sans Pro',
        583 => 'Special Elite',
        584 => 'Spicy Rice',
        585 => 'Spinnaker',
        586 => 'Spirax',
        587 => 'Squada One',
        588 => 'Stalemate',
        589 => 'Stalinist One',
        590 => 'Stardos Stencil',
        591 => 'Stint Ultra Condensed',
        592 => 'Stint Ultra Expanded',
        593 => 'Stoke',
        594 => 'Strait',
        595 => 'Sue Ellen Francisco',
        596 => 'Sunshiney',
        597 => 'Supermercado One',
        598 => 'Suwannaphum',
        599 => 'Swanky and Moo Moo',
        600 => 'Syncopate',
        601 => 'Tangerine',
        602 => 'Taprom',
        603 => 'Tauri',
        604 => 'Telex',
        605 => 'Tenor Sans',
        606 => 'Text Me One',
        607 => 'The Girl Next Door',
        608 => 'Tienne',
        609 => 'Tinos',
        610 => 'Titan One',
        611 => 'Titillium Web',
        612 => 'Trade Winds',
        613 => 'Trocchi',
        614 => 'Trochut',
        615 => 'Trykker',
        616 => 'Tulpen One',
        617 => 'Ubuntu',
        618 => 'Ubuntu Condensed',
        619 => 'Ubuntu Mono',
        620 => 'Ultra',
        621 => 'Uncial Antiqua',
        622 => 'Underdog',
        623 => 'Unica One',
        624 => 'UnifrakturCook',
        625 => 'UnifrakturMaguntia',
        626 => 'Unkempt',
        627 => 'Unlock',
        628 => 'Unna',
        629 => 'VT323',
        630 => 'Vampiro One',
        631 => 'Varela',
        632 => 'Varela Round',
        633 => 'Vast Shadow',
        634 => 'Vibur',
        635 => 'Vidaloka',
        636 => 'Viga',
        637 => 'Voces',
        638 => 'Volkhov',
        639 => 'Vollkorn',
        640 => 'Voltaire',
        641 => 'Waiting for the Sunrise',
        642 => 'Wallpoet',
        643 => 'Walter Turncoat',
        644 => 'Warnes',
        645 => 'Wellfleet',
        646 => 'Wendy One',
        647 => 'Wire One',
        648 => 'Yanone Kaffeesatz',
        649 => 'Yellowtail',
        650 => 'Yeseva One',
        651 => 'Yesteryear',
        652 => 'Zeyada',
        653 => 'Work Sans',
        654 => 'Alegreya Sans',
        655 => 'Alegreya Sans SC',
        656 => 'Amiri',
        657 => 'Amita',
        658 => 'Arya',
        659 => 'Asar',
        660 => 'Biryani',
        661 => 'Cambay',
        662 => 'Catamaran',
        663 => 'Caveat',
        664 => 'Caveat Brush',
        665 => 'Chonburi',
        666 => 'Dekko',
        667 => 'Dhurjati',
        668 => 'Eczar',
        669 => 'Ek Mukta',
        670 => 'Exo 2',
        671 => 'Fira Mono',
        672 => 'Fira Sans',
        673 => 'Gidugu',
        674 => 'Gurajada',
        675 => 'Halant',
        676 => 'Hind',
        677 => 'Hind Siliguri',
        678 => 'Hind Vadodara',
        679 => 'Inknut Antiqua',
        680 => 'Itim',
        681 => 'Jaldi',
        682 => 'Kadwa',
        683 => 'Kalam',
        684 => 'Kantumruy',
        685 => 'Karma',
        686 => 'Kdam Thmor',
        687 => 'Khand',
        688 => 'Khula',
        689 => 'Kurale',
        690 => 'Laila',
        691 => 'Lakki Reddy',
        692 => 'Lateef',
        693 => 'Mallanna',
        694 => 'Mandali',
        695 => 'Martel',
        696 => 'Martel Sans',
        697 => 'Modak',
        698 => 'NTR',
        699 => 'Palanquin',
        700 => 'Palanquin Dark',
        701 => 'Peddana',
        702 => 'Poppins',
        703 => 'Pragati Narrow',
        704 => 'Rajdhani',
        705 => 'Ramabhadra',
        706 => 'Ramaraja',
        707 => 'Ranga',
        708 => 'Ravi Prakash',
        709 => 'Rhodium Libre',
        710 => 'Roboto Mono',
        711 => 'Rozha One',
        712 => 'Rubik',
        713 => 'Rubik Mono One',
        714 => 'Rubik One',
        715 => 'Sahitya',
        716 => 'Sarala',
        717 => 'Sarpanch',
        718 => 'Scheherazade',
        719 => 'Slabo 13px',
        720 => 'Slabo 27px',
        721 => 'Source Serif Pro',
        722 => 'Sree Krushnadevaraya',
        723 => 'Sumana',
        724 => 'Sura',
        725 => 'Suranna',
        726 => 'Suravaram',
        727 => 'Teko',
        728 => 'Tenali Ramakrishna',
        729 => 'Tillana',
        730 => 'Timmana',
        731 => 'Vesper Libre',
        732 => 'Yantramanav'
    );


    //returns the font family for css generator
    public static function css_get_font_family($css_array) {
        if(!empty($css_array['font_family'])) {
            $explode_font_family = explode('_', $css_array['font_family']);

            $font_id = $explode_font_family[1];

            switch ($explode_font_family[0]) {
                //fonts from files (links to files)
                case 'file':
                    $css_array['font_family'] = stripcslashes(td_global::$td_options['td_fonts_user_inserted']['font_family_' . $font_id]);
                    break;

                //fonts from type kit
                case 'tk':
                    $css_array['font_family'] = stripcslashes(td_global::$td_options['td_fonts_user_inserted']['type_kit_font_family_' . $font_id]);
                    break;

                //fonts from font stacks
                case 'fs':
                    $css_array['font_family'] = self::$font_stack_list['fs_' . $font_id];
                    break;

                //fonts from google
                case 'g':
                    $google_font_name = trim(self::$font_names_google_list[$font_id]);

                    //search for space in google font names
                    if(preg_match('/\s/', $google_font_name)) {
                        $google_font_name  = '"' . $google_font_name . '"';
                    }

                    $css_array['font_family'] = $google_font_name;
                    break;
            }
        }

        return $css_array;
    }


    /**
     * add the typography css to the theme generated css
     *
     * used in : @see td_css_generator.php
     */
    public static function td_get_typography_sections_from_db() {

        $typography_sections_css_array = array();

        foreach (td_global::$typography_settings_list as $panel_section => $font_settings_array) {
            foreach($font_settings_array as $font_setting_id => $font_setting_name) {

                //store $typography section array in a variable
                if(!empty(td_global::$td_options['td_fonts'][$font_setting_id])) {
                    $section_css = td_global::$td_options['td_fonts'][$font_setting_id];
                    /**
                     * replace the font family in this section
                     * - in database the font family is stored like g_xxx for google, tk_x for typekit, fs_x for font stacks, where x are integers
                     *   and here we replace with their css corespondent
                     */
                    if(!empty($section_css['font_family'])) {
                        $section_css = self::css_get_font_family($section_css);
                    }

                    $typography_sections_css_array[$font_setting_id] = $section_css;
                }
            }
        }



        if(!empty($typography_sections_css_array)) {
            return $typography_sections_css_array;
        } else {
            return false;
        }
    }


    /**
     * add td_fonts_css_buffer from database into the source of the page
     *
     * td_fonts_css_buffer : used to store the css generated for custom font files in the database
     *
     * used in : @see td_css_generator.php
     */
    public static function td_add_fonts_css_buffer() {
        $td_fonts_css_buffer = td_util::get_option('td_fonts_css_buffer');

        if(!empty($td_fonts_css_buffer)) {
            return $td_fonts_css_buffer . "\n";
        } else {
            return '';
        }
    }

    static function get_google_fonts_names($fonts_ids_array) {
        $temp_css_google_files = '';
        if(!empty($fonts_ids_array)) {
            foreach($fonts_ids_array as $g_font_id) {
                $font_id = str_replace('g_', '', $g_font_id);
                if(!empty($temp_css_google_files)) {
                    $temp_css_google_files .= '|';
                }
                $temp_css_google_files .= str_replace(' ', '+', td_fonts::$font_names_google_list[$font_id]);
            }
        }
        return $temp_css_google_files;
    }


    static function get_google_fonts_subset_query() {
        //check the character set saved in the database
        $array_google_char_set = array(
            'g_arabic',
            'g_bengali',
            'g_cyrillic',
            'g_cyrillic-ext',
            'g_devanagari',
            'g_greek',
            'g_greek-ext',
            'g_gujarati',
            'g_hebrew',
            'g_khmer',
            'g_latin',
            'g_latin-ext',
            'g_tamil',
            'g_telugu',
            'g_thai',
            'g_vietnamese'
        );

        $tmp_google_subset = '';
        foreach($array_google_char_set as $val_charset) {
            if(!empty(td_global::$td_options['td_fonts_user_inserted'][$val_charset])) {
                if (empty($tmp_google_subset)) {
                    $tmp_google_subset = td_global::$td_options['td_fonts_user_inserted'][$val_charset];
                } else {
                    $tmp_google_subset .= ',' . td_global::$td_options['td_fonts_user_inserted'][$val_charset];
                }

            }
        }

        if(!empty($tmp_google_subset)) {
            return '&subset=' . $tmp_google_subset;
        }

        return '';
    }
}//end class









/**
 * adds the javascript to be used when user ads typekit fonts
 *
 * td_fonts_js_buffer : holds the typekit javascript in the database
 */
function td_add_js_typekit() {
    $td_fonts_js_buffer = stripcslashes(td_util::get_option('td_fonts_js_buffer'));

    if(!empty($td_fonts_js_buffer)) {
        echo $td_fonts_js_buffer;
    }
}
//add the js to the footer
add_action('wp_footer', 'td_add_js_typekit', 100);


/**
 * Insert style in Tiny MCE in admin post page
 * /
function my_admin_footer_function() {
    $screen_arr = get_current_screen();
    //print_r($screen_arr);

    //run only on admin post page
    if($screen_arr->post_type == 'post') {

        //get the typography generated css from database
        $td_typography_generated_css = td_util::get_option('tds_user_compile_css');
        if(!empty($td_typography_generated_css)) {
            //$td_typography_generated_css = '<style>' . $td_typography_generated_css . '</style>';
            echo '<script>
                    jQuery().ready(function() {
                        td_tmce_post_page_font_insertion();
                    });

                    /* insert the typography generated css into Tiny MCE editor * /
                    function td_tmce_post_page_font_insertion() {

                        /* wait for a second for Tine MCE to insert the iframe * /
                        var tmce_post_page_font = setTimeout(function(){
                            if(document.getElementById("content_ifr")) {
                                //console.log("iframe gasit");
                                jQuery("#content_ifr").contents().find("body").addClass("td-post-content");

                                jQuery("#content_ifr").contents().find("head").append(\'<style>.td-post-content {color:#ff0000 !important;font-size:13px;line-height:13px;font-style:italic;font-weight:bold;text-transform:uppercase;}</style>\');
                            } else {
                                //console.log("iframe nu este gasit");
                                clearTimeout(tmce_post_page_font);

                                //call the function again
                                td_tmce_post_page_font_insertion();
                            }
                        }, 1000);
                    }
                  </script>';
        }
    }
}
add_action('admin_footer', 'my_admin_footer_function');*/
