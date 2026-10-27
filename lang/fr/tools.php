<?php

return [

    'word-counter' => [
        'name' => 'Compteur de mots',
        'title' => 'Compteur de mots : compter mots et caractères gratuitement',
        'description' => 'Compteur de mots gratuit : comptez mots, caractères, phrases et paragraphes en direct, avec temps de lecture et mots-clés. Sans inscription.',
        'h1' => 'Compteur de mots',
        'tagline' => 'Comptez les mots, les caractères, les phrases et le temps de lecture instantanément.',
        'keywords' => ['compteur de mots', 'compteur de caractères', 'nombre de mots', 'compter les mots en ligne', 'calcul du temps de lecture'],
        'intro' => 'Un compteur de mots est un outil qui compte les mots, les caractères, les phrases et les paragraphes d’un texte. Collez ou saisissez votre texte ci-dessous pour compter les mots, caractères, phrases et paragraphes au fil de la frappe. Le compteur affiche aussi le temps de lecture et de parole estimé ainsi que vos mots-clés les plus utilisés, pratique pour les dissertations, articles de blog, légendes de réseaux sociaux et méta-descriptions SEO.',
        'steps' => [
            'Saisissez ou collez votre texte dans la zone.',
            'Regardez le nombre de mots, de caractères, de phrases et de paragraphes se mettre à jour en direct.',
            'Consultez le temps de lecture, le temps de parole et la densité des mots-clés sous la zone.',
            'Utilisez Copier ou Effacer quand vous avez terminé.',
        ],
        'features' => [
            'Comptage en direct des mots, caractères, phrases et paragraphes',
            'Caractères avec et sans espaces',
            'Temps de lecture (238 mots/min) et de parole (150 mots/min)',
            'Densité des principaux mots-clés pour éviter les répétitions',
            'Fonctionne hors ligne une fois chargé : votre texte n’est jamais envoyé',
        ],
        'content' => [
            [
                'heading' => 'Pourquoi le nombre de mots compte-t-il ?',
                'body' => 'Écoles, universités et éditeurs imposent souvent des limites de mots strictes, et les réseaux sociaux plafonnent le nombre de caractères par publication. Les moteurs de recherche affichent en général environ 155-160 caractères d’une méta-description, et une balise title devrait rester sous 60 caractères environ. Connaître votre nombre exact vous aide à atteindre ces objectifs sans deviner.',
            ],
            [
                'heading' => 'Comment les mots sont-ils comptés ?',
                'body' => 'Un mot est un groupe de lettres ou de chiffres séparé par des espaces ou des retours à la ligne. La ponctuation seule ne compte pas comme un mot. Les phrases sont comptées grâce à la ponctuation finale (. ! ?) et les paragraphes grâce aux lignes vides : les chiffres correspondent donc à ceux de traitements de texte comme Microsoft Word et Google Docs.',
            ],
        ],
        'faqs' => [
            ['q' => 'Ce compteur de mots est-il gratuit ?', 'a' => 'Oui. Le compteur de mots est entièrement gratuit, sans inscription et sans limite sur la quantité de texte collé.'],
            ['q' => 'Mon texte est-il enregistré ou envoyé ?', 'a' => 'Non. Le comptage se fait entièrement dans votre navigateur. Votre texte n’est jamais envoyé à notre serveur ni stocké nulle part.'],
            ['q' => 'Comment le temps de lecture est-il calculé ?', 'a' => 'Le temps de lecture se base sur une vitesse moyenne de lecture silencieuse de 238 mots par minute chez l’adulte. Le temps de parole utilise 150 mots par minute, un rythme typique pour une présentation.'],
            ['q' => 'Un « compteur de mots » est-il la même chose qu\'un « compteur de texte » ?', 'a' => 'Oui. Compteur de mots, compteur de texte et compteur de caractères désignent le même outil : il compte les mots, caractères, phrases et paragraphes de votre texte.'],
            ['q' => 'Compte-t-il les caractères avec les espaces ?', 'a' => 'Oui. Vous obtenez les caractères avec espaces et sans espaces, ce à quoi se réfèrent la plupart des limites de caractères.'],
        ],
    ],

    'case-converter' => [
        'name' => 'Convertisseur de casse',
        'title' => 'Convertisseur de casse : majuscules, minuscules et titre',
        'description' => 'Convertissez un texte en MAJUSCULES, minuscules, Titre, Phrase, camelCase, snake_case et plus. Convertisseur de casse en ligne gratuit, instantané et privé.',
        'h1' => 'Convertisseur de casse',
        'tagline' => 'Passez un texte en majuscules, minuscules, titre, phrase, camel ou snake case en un clic.',
        'keywords' => ['convertisseur de casse', 'majuscules en minuscules', 'convertir en majuscules', 'casse phrase', 'convertisseur camelcase'],
        'intro' => 'Un convertisseur de casse est un outil qui change les majuscules d’un texte, par exemple de MAJUSCULES en minuscules. Vous avez tapé avec la touche Verr. Maj activée ou il vous faut un titre avec des majuscules ? Collez votre texte et cliquez sur un bouton pour le convertir instantanément. Les développeurs peuvent aussi basculer entre camelCase, PascalCase, snake_case, kebab-case et CONSTANT_CASE.',
        'steps' => [
            'Collez votre texte dans la zone.',
            'Cliquez sur la casse voulue, par exemple Titre ou minuscules.',
            'Copiez le texte converti ou téléchargez-le en fichier .txt.',
        ],
        'features' => [
            'MAJUSCULES, minuscules, Titre et Phrase',
            'camelCase, PascalCase, snake_case, kebab-case, CONSTANT_CASE',
            'aLtErNé et InVeRsÉ pour des publications amusantes',
            'Casse Titre intelligente qui laisse en minuscules les petits mots comme « et » et « de »',
            'Copiez ou téléchargez le résultat',
        ],
        'content' => [
            [
                'heading' => 'Casse Titre ou casse Phrase : quelle est la différence ?',
                'body' => 'La casse Titre met une majuscule aux mots principaux d’un titre (« Le Guide Rapide du SEO »), tandis que les petits mots comme le, et, de et du restent en minuscules sauf en début de titre. La casse Phrase ne met une majuscule qu’au premier mot de chaque phrase (« Le guide rapide du SEO »), ce que préfèrent de nombreux sites modernes pour la lisibilité. En français, c’est d’ailleurs la norme typographique.',
            ],
            [
                'heading' => 'Quelles casses sont utilisées en programmation ?',
                'body' => 'Le camelCase est courant pour les variables JavaScript, le PascalCase pour les noms de classes, le snake_case en Python et pour les colonnes de bases de données, le kebab-case pour les URL et les classes CSS, et le CONSTANT_CASE pour les constantes et les variables d’environnement.',
            ],
        ],
        'faqs' => [
            ['q' => 'Comment convertir des majuscules en minuscules ?', 'a' => 'Collez votre texte et cliquez sur « minuscules ». Chaque lettre est convertie instantanément, et vous pouvez copier le résultat en un clic.'],
            ['q' => 'La casse Titre met-elle une majuscule à chaque mot ?', 'a' => 'Non. Elle suit les guides de style courants et laisse les petits mots (le, la, un, et, mais, ou, de, en, à, pour) en minuscules, sauf s’ils sont en premier ou en dernier.'],
            ['q' => 'Y a-t-il une limite de longueur ?', 'a' => 'Pas en pratique. La conversion se fait dans votre navigateur : même les longs documents sont convertis instantanément.'],
            ['q' => 'Les lettres accentuées sont-elles prises en charge ?', 'a' => 'Oui. Les lettres accentuées et les caractères d’autres langues, comme é, ç, ü et ñ, sont convertis correctement.'],
        ],
    ],

    'password-generator' => [
        'name' => 'Générateur de mots de passe',
        'title' => 'Générateur de mots de passe forts et aléatoires gratuit',
        'description' => 'Générez des mots de passe forts et aléatoires : longueur, symboles et chiffres au choix. Créés sur votre appareil, jamais envoyés.',
        'h1' => 'Générateur de mots de passe forts',
        'tagline' => 'Créez des mots de passe sécurisés et aléatoires en un clic, générés sur votre appareil.',
        'keywords' => ['générateur de mot de passe', 'générateur de mot de passe fort', 'mot de passe aléatoire', 'mot de passe sécurisé'],
        'intro' => 'Un générateur de mots de passe est un outil qui crée des mots de passe aléatoires et difficiles à deviner avec les caractères de votre choix. Créez un mot de passe fort et aléatoire, presque impossible à deviner. Choisissez la longueur et les caractères à inclure : le générateur utilise le générateur de nombres aléatoires cryptographiquement sûr de votre navigateur. Les mots de passe ne sont jamais envoyés à notre serveur.',
        'steps' => [
            'Choisissez la longueur du mot de passe (16 ou plus recommandé).',
            'Cochez les types de caractères à inclure : majuscules, minuscules, chiffres et symboles.',
            'Cliquez sur Générer, puis sur Copier pour utiliser votre nouveau mot de passe.',
        ],
        'features' => [
            'Longueur de 4 à 128 caractères',
            'Majuscules, minuscules, chiffres et symboles',
            'Option pour exclure les caractères qui se ressemblent (l, 1, I, O, 0)',
            'Indicateur de robustesse basé sur l’entropie réelle',
            'Utilise crypto.getRandomValues : sûr et sans biais',
        ],
        'content' => [
            [
                'heading' => 'Qu’est-ce qu’un mot de passe fort ?',
                'body' => 'La longueur compte le plus. Chaque caractère supplémentaire multiplie le nombre de combinaisons possibles. Un mot de passe de 16 caractères avec majuscules, minuscules, chiffres et symboles dépasse 100 bits d’entropie, ce qui demanderait des milliards d’années à casser par force brute avec le matériel actuel.',
            ],
            [
                'heading' => 'Comment protéger mes mots de passe ?',
                'body' => 'Utilisez un mot de passe différent pour chaque compte, conservez-les dans un gestionnaire de mots de passe et activez la double authentification partout où c’est possible. Ne réutilisez jamais un mot de passe apparu dans une fuite de données.',
            ],
        ],
        'faqs' => [
            ['q' => 'Ce générateur de mots de passe est-il sûr ?', 'a' => 'Oui. Les mots de passe sont générés dans votre navigateur avec la Web Crypto API. Rien n’est envoyé à notre serveur, journalisé ou stocké.'],
            ['q' => 'Quelle longueur choisir ?', 'a' => 'Au moins 15 caractères, le minimum des recommandations actuelles du NIST (SP 800-63B), et 16 ou plus pour les comptes importants comme la messagerie et la banque.'],
            ['q' => 'À quoi sert « exclure les caractères similaires » ?', 'a' => 'Cette option retire les caractères qui se ressemblent, comme l, 1, I, O et 0, pour que le mot de passe soit plus facile à lire et à saisir à la main.'],
            ['q' => 'Qu’est-ce que l’entropie d’un mot de passe ?', 'a' => 'L’entropie mesure en bits à quel point un mot de passe est imprévisible. Chaque bit supplémentaire double le nombre d’essais nécessaires à un attaquant. 80 bits et plus, c’est fort ; 100 bits et plus, c’est excellent.'],
        ],
        'table' => [
            'caption' => 'Longueur et robustesse d’un mot de passe (entropie en bits)',
            'headers' => ['Longueur', 'Lettres et chiffres (62 caractères)', 'Lettres, chiffres et symboles (89 caractères)'],
            'rows' => [
                ['8', '48', '52'],
                ['12', '71', '78'],
                ['16', '95', '104'],
                ['20', '119', '130'],
                ['32', '191', '207'],
            ],
        ],
    ],

    'qr-code-generator' => [
        'name' => 'Générateur de QR code',
        'title' => 'Générateur de QR code gratuit pour URL, Wi-Fi et plus',
        'description' => 'Créez des QR codes gratuits pour liens, texte, Wi-Fi, e-mail, téléphone et SMS. Couleurs et tailles au choix, PNG ou SVG, sans expiration.',
        'h1' => 'Générateur de QR code gratuit',
        'tagline' => 'Créez des QR codes pour liens, Wi-Fi, e-mail, téléphone et SMS. Téléchargez en PNG ou SVG.',
        'keywords' => ['générateur de qr code', 'qr code gratuit', 'qr code wifi', 'créer un qr code', 'qr code pour url'],
        'intro' => 'Un générateur de QR code est un outil qui transforme un lien, un texte ou des identifiants Wi-Fi en code carré lisible par l’appareil photo d’un téléphone. Créez en quelques secondes un QR code pour un lien, un texte, un réseau Wi-Fi, un e-mail, un numéro de téléphone ou un SMS. Choisissez les couleurs et la taille, puis téléchargez un PNG de haute qualité pour l’écran ou un SVG pour l’impression. Ce sont des QR codes statiques : ils fonctionnent pour toujours et n’expirent jamais.',
        'steps' => [
            'Choisissez le type de QR code : URL, Texte, Wi-Fi, E-mail, Téléphone ou SMS.',
            'Remplissez les informations. L’aperçu se met à jour pendant la saisie.',
            'Ajustez la taille, les couleurs et la correction d’erreurs si vous le souhaitez.',
            'Téléchargez en PNG ou SVG et testez-le avec l’appareil photo de votre téléphone.',
        ],
        'features' => [
            'QR codes URL, texte, Wi-Fi, e-mail, téléphone et SMS',
            'Couleurs de premier plan et de fond personnalisées',
            'Tailles de 128 px à 1024 px',
            'Niveaux de correction d’erreurs L, M, Q et H',
            'Téléchargement PNG et SVG, gratuit pour un usage commercial',
            'Codes statiques sans expiration et sans pistage',
        ],
        'content' => [
            [
                'heading' => 'Comment créer un QR code Wi-Fi ?',
                'body' => 'Choisissez le type Wi-Fi et saisissez le nom du réseau (SSID), le mot de passe et le type de sécurité. Vos invités n’ont plus qu’à scanner le code avec l’appareil photo de leur téléphone pour se connecter sans taper le mot de passe : idéal pour la maison, les cafés et les bureaux.',
            ],
            [
                'heading' => 'Comment créer un QR code toujours lisible ?',
                'body' => 'Gardez un contraste fort avec un code sombre sur fond clair, laissez la marge blanche autour du code et imprimez-le en au moins 2 x 2 cm. Choisissez un niveau de correction d’erreurs plus élevé si le code risque d’être rayé ou sali.',
            ],
        ],
        'faqs' => [
            ['q' => 'Ces QR codes expirent-ils ?', 'a' => 'Non. Ce sont des QR codes statiques qui contiennent directement vos données : ils fonctionnent pour toujours et ne dépendent pas de notre site.'],
            ['q' => 'Puis-je utiliser ces QR codes à des fins commerciales ?', 'a' => 'Oui. Vous pouvez utiliser gratuitement les QR codes générés sur des flyers, emballages, menus et cartes de visite.'],
            ['q' => 'Faut-il télécharger en PNG ou en SVG ?', 'a' => 'Le PNG convient le mieux aux sites web et aux documents. Le SVG est un format vectoriel qui reste net à toutes les tailles, idéal pour l’impression.'],
            ['q' => 'Qu’est-ce que la correction d’erreurs ?', 'a' => 'La correction d’erreurs permet à un QR code de rester lisible même s’il est partiellement abîmé. Le niveau L restaure environ 7 % du code et le niveau H environ 30 %, mais les niveaux élevés rendent le code plus dense.'],
            ['q' => 'Pourquoi mon QR code ne se scanne-t-il pas ?', 'a' => 'En général, les couleurs sont trop proches ou inversées (code clair sur fond sombre). Utilisez un code sombre sur fond clair avec un bon contraste.'],
        ],
        'table' => [
            'caption' => 'Niveaux de correction d’erreurs des QR codes',
            'headers' => ['Niveau', 'Restaure jusqu’à', 'Adapté à'],
            'rows' => [
                ['L', '7 %', 'Écrans propres et codes contenant beaucoup de données'],
                ['M', '15 %', 'La plupart des usages (le choix le plus courant)'],
                ['Q', '25 %', 'Codes imprimés qui risquent d’être salis'],
                ['H', '30 %', 'Conditions difficiles, comme les étiquettes d’usine'],
            ],
        ],
    ],

    'image-compressor' => [
        'name' => 'Compresseur d’images',
        'title' => 'Compresseur d’images : compresser JPG, PNG et WebP en ligne',
        'description' => 'Compressez des images JPG, PNG et WebP gratuitement. Réduisez une photo à 100 Ko sans perte visible. Rien ne quitte votre appareil.',
        'h1' => 'Compresseur d’images',
        'tagline' => 'Réduisez le poids des fichiers JPG, PNG et WebP, même à une taille précise comme 100 Ko.',
        'keywords' => ['compresseur d’image', 'compresser une image', 'compresser une image à 100 ko', 'réduire la taille d’une image', 'compresser jpg'],
        'intro' => 'Un compresseur d’images est un outil qui réduit le poids des fichiers image sans changer leur apparence. Allégez vos images sans perte de qualité visible. Déposez un ou plusieurs fichiers JPG, PNG ou WebP, choisissez un niveau de qualité ou une taille cible comme 100 Ko, puis téléchargez les images compressées. La compression se fait dans votre navigateur : vos photos ne sont jamais envoyées.',
        'steps' => [
            'Glissez-déposez des images ou cliquez pour choisir des fichiers (JPG, PNG ou WebP).',
            'Choisissez un niveau de qualité ou définissez une taille cible, par exemple 100 Ko.',
            'Choisissez éventuellement un format de sortie et une largeur maximale.',
            'Téléchargez chaque image ou toutes en un ZIP.',
        ],
        'features' => [
            'Compressez jusqu’à 30 images à la fois',
            'Mode taille cible, par exemple « compresser à 100 Ko »',
            'Conversion en WebP pour un gain maximal',
            'Largeur maximale facultative pour réduire les très grandes photos',
            'Poids avant et après avec le % gagné',
            '100 % privé : traité dans votre navigateur',
        ],
        'content' => [
            [
                'heading' => 'Pourquoi compresser les images ?',
                'body' => 'Les images lourdes sont la cause la plus fréquente de lenteur des pages web, et la vitesse de chargement est un critère de classement Google. Les images plus légères s’envoient aussi plus vite dans les formulaires et portails d’emploi qui imposent des limites comme 100 Ko, 200 Ko ou 1 Mo.',
            ],
            [
                'heading' => 'Quel format choisir ?',
                'body' => 'Le JPG est idéal pour les photos. Le PNG conserve la transparence et les contours nets pour les logos et captures d’écran, mais ses fichiers sont lourds. Le WebP donne les fichiers les plus légers pour les photos comme pour les graphismes et est pris en charge par tous les navigateurs modernes.',
            ],
        ],
        'faqs' => [
            ['q' => 'Comment compresser une image à 100 Ko ?', 'a' => 'Choisissez « Taille cible », saisissez 100 et cliquez sur Compresser. L’outil trouve la meilleure qualité qui tient sous 100 Ko et ne réduit les dimensions de l’image que si nécessaire.'],
            ['q' => 'Mes images sont-elles envoyées sur un serveur ?', 'a' => 'Non. Les images sont compressées dans votre navigateur grâce à l’API Canvas. Elles ne quittent jamais votre appareil.'],
            ['q' => 'La compression réduit-elle la qualité ?', 'a' => 'À la qualité par défaut (75 %), la plupart des gens ne voient aucune différence, alors que le poids baisse souvent de 50 à 80 %.'],
            ['q' => 'Comment réduire la taille d\'une image PNG ?', 'a' => 'Le PNG est un format sans perte, donc le compresser seul change peu de choses. Pour vraiment réduire la taille d\'un PNG, choisissez WebP (conserve la transparence) ou JPG (si vous n\'avez pas besoin de transparence) comme format de sortie : les deux réduisent nettement le poids du PNG sans perte de qualité visible.'],
            ['q' => 'Comment réduire la taille d’un JPG en ligne ?', 'a' => 'Importez votre JPG, choisissez « Taille cible » ou une qualité autour de 60-80 %, puis cliquez sur Compresser. Pour une photo, une qualité JPG de 70-80 % suffit généralement à réduire nettement le poids sans perte visible.'],
        ],
        'table' => [
            'caption' => 'Quel format d’image choisir',
            'headers' => ['Format', 'Idéal pour', 'Transparence'],
            'rows' => [
                ['JPG', 'Photos', 'Non'],
                ['PNG', 'Logos, captures d’écran, graphismes nets', 'Oui'],
                ['WebP', 'Sites web (fichiers les plus légers pour photos et graphismes)', 'Oui'],
            ],
        ],
    ],

    'image-resizer' => [
        'name' => 'Redimensionner une image',
        'title' => 'Redimensionner une image en ligne : JPG, PNG, WebP gratuit',
        'description' => 'Redimensionnez une image au pixel près ou en pourcentage et convertissez JPG, PNG et WebP. Gratuit, en ligne et sans envoyer vos photos.',
        'h1' => 'Redimensionner et convertir une image',
        'tagline' => 'Redimensionnez au pixel près ou en pourcentage, et convertissez JPG, PNG et WebP.',
        'keywords' => ['redimensionner une image', 'changer la taille d’une image', 'png en jpg', 'jpg en png', 'webp en jpg', 'convertisseur d’image'],
        'intro' => 'Un outil de redimensionnement change la largeur et la hauteur d’une image, et un convertisseur change son format de fichier. Redimensionnez une photo aux dimensions exactes d’un réseau social, d’un formulaire de passeport ou de votre site, ou changez son échelle en pourcentage. Vous pouvez aussi convertir le format, par exemple PNG en JPG ou WebP en PNG. Tout se passe dans votre navigateur.',
        'steps' => [
            'Choisissez ou déposez une image (JPG, PNG, WebP, GIF ou BMP).',
            'Saisissez une nouvelle largeur et une nouvelle hauteur, ou choisissez un pourcentage.',
            'Choisissez le format de sortie et la qualité.',
            'Cliquez sur Télécharger pour enregistrer l’image redimensionnée.',
        ],
        'features' => [
            'Redimensionnement en pixels ou en pourcentage',
            'Conservation des proportions pour éviter la déformation',
            'Conversion entre JPG, PNG et WebP',
            'Réglage de la qualité pour JPG et WebP',
            'Aperçu en direct avec le nouveau poids du fichier',
        ],
        'content' => [
            [
                'heading' => 'Quelle taille donner à mon image ?',
                'body' => 'Les publications Instagram rendent bien en 1080 x 1080 pixels, les images partagées sur Facebook et LinkedIn en 1200 x 630, les miniatures YouTube en 1280 x 720, et les grandes images de sites web ne dépassent généralement pas 1920 pixels de large.',
            ],
            [
                'heading' => 'Comment convertir un PNG en JPG ?',
                'body' => 'Le JPG ne gère pas la transparence : les zones transparentes deviennent blanches quand vous convertissez un PNG en JPG. Pour conserver la transparence, choisissez PNG ou WebP comme format de sortie.',
            ],
        ],
        'faqs' => [
            ['q' => 'Comment redimensionner une image sans la déformer ?', 'a' => 'Laissez « Conserver les proportions » coché. Quand vous changez la largeur, la hauteur s’ajuste automatiquement pour garder les proportions d’origine.'],
            ['q' => 'Puis-je convertir un WebP en JPG ?', 'a' => 'Oui. Ouvrez votre image WebP, choisissez JPG comme format de sortie et téléchargez.'],
            ['q' => 'Redimensionner réduit-il la qualité ?', 'a' => 'Réduire une image la garde nette. L’agrandir beaucoup au-delà de l’original peut la rendre floue, car aucun nouveau détail ne peut être créé.'],
            ['q' => 'Quelle est la taille maximale ?', 'a' => 'Les images de sortie peuvent atteindre 10 000 pixels de côté, ce que tous les navigateurs modernes savent gérer.'],
        ],
        'table' => [
            'caption' => 'Tailles d’image courantes',
            'headers' => ['Usage', 'Taille (pixels)'],
            'rows' => [
                ['Publication carrée Instagram', '1080 × 1080'],
                ['Image partagée sur Facebook et LinkedIn', '1200 × 630'],
                ['Miniature YouTube', '1280 × 720'],
                ['Image pleine largeur d’un site', 'jusqu’à 1920 de large'],
            ],
        ],
    ],

    'jpg-to-pdf' => [
        'name' => 'JPG en PDF',
        'title' => 'JPG en PDF : convertir des images en PDF gratuitement',
        'description' => 'Convertissez des images JPG, PNG ou WebP en PDF gratuitement. Réorganisez les photos, choisissez format, orientation et marges. Sans envoi ni filigrane.',
        'h1' => 'JPG en PDF',
        'tagline' => 'Combinez des images JPG, PNG et WebP en un seul fichier PDF.',
        'keywords' => ['jpg en pdf', 'convertir jpg en pdf', 'image en pdf', 'jpg en pdf en ligne', 'convertisseur jpg pdf'],
        'intro' => 'Un convertisseur JPG en PDF transforme des images JPG, PNG ou WebP en un seul document PDF. Ajoutez plusieurs photos, réorganisez-les, puis choisissez le format de page, l’orientation et les marges avant de les combiner en un seul document. Ce convertisseur jpg en pdf fonctionne entièrement sur votre appareil : vos images ne sont jamais envoyées à un serveur.',
        'steps' => [
            'Ajoutez une ou plusieurs images JPG, PNG ou WebP en les déposant ou en cliquant pour parcourir.',
            'Réorganisez les images avec les flèches haut et bas si besoin.',
            'Choisissez un format de page, une orientation et une marge.',
            'Cliquez sur Convertir en PDF et téléchargez votre fichier.',
        ],
        'features' => [
            'Combinez des images JPG, PNG et WebP en un seul PDF',
            'Réorganisez ou retirez des images avant la conversion',
            'Formats de page A4, Lettre US ou Ajuster à l’image',
            'Orientation de page automatique ou manuelle',
            'Marges ajustables autour de chaque photo',
            'Privé : les images ne quittent jamais votre appareil',
        ],
        'content' => [
            [
                'heading' => 'Quel format de page choisir ?',
                'body' => 'A4 et Lettre US ajoutent de l’espace blanc autour des photos qui ne correspondent pas à la forme de la page, ce qui convient aux documents et à l’impression. Ajuster à l’image règle la taille de la page PDF exactement sur chaque photo, en gardant l’image entière visible sans bordure blanche : pratique quand vous avez juste besoin d’une copie PDF rapide d’une photo.',
            ],
            [
                'heading' => 'Pourquoi convertir JPG en PDF ?',
                'body' => 'Un seul PDF est plus simple à envoyer par e-mail, à imprimer et à téléverser sur des formulaires que plusieurs fichiers image séparés. Combiner des pages scannées, des reçus ou des photos en un seul PDF permet aussi de les garder dans le bon ordre et évite qu’ils se mélangent.',
            ],
        ],
        'faqs' => [
            ['q' => 'Puis-je combiner plusieurs images en un seul PDF ?', 'a' => 'Oui. Ajoutez autant d’images JPG, PNG ou WebP que vous voulez, mettez-les dans l’ordre souhaité avec les flèches, et elles sont combinées en un seul PDF.'],
            ['q' => 'Ce convertisseur JPG en PDF ajoute-t-il un filigrane ?', 'a' => 'Non. Le PDF ne contient que vos images, sans filigrane, logo ni page ajoutée.'],
            ['q' => 'Puis-je aussi convertir des images PNG et WebP, pas seulement JPG ?', 'a' => 'Oui. Les images JPG, PNG et WebP sont toutes prises en charge et peuvent être mélangées dans le même PDF.'],
            ['q' => 'À quoi sert le réglage de marge ?', 'a' => 'Il ajoute un espace blanc autour de chaque image sur la page. Choisissez Aucune pour que l’image touche les bords, ou une marge plus grande pour un rendu plus proche d’un document.'],
            ['q' => 'La qualité de mes images est-elle réduite ?', 'a' => 'Les images JPG et PNG sont intégrées à leur qualité d’origine. Les images WebP sont d’abord converties en PNG, ce qui conserve une qualité sans perte.'],
        ],
    ],

    'webp-to-png' => [
        'name' => 'WebP en PNG',
        'title' => 'Convertir WebP en PNG gratuitement, par lot',
        'description' => 'Convertissez des WebP en PNG en ligne gratuitement. Jusqu’à 30 images à la fois, transparence conservée et téléchargement en ZIP. Rien n’est envoyé.',
        'h1' => 'Convertir WebP en PNG',
        'tagline' => 'Transformez des images WebP en PNG en quelques secondes, transparence comprise.',
        'keywords' => ['webp en png', 'convertir webp en png', 'convertisseur webp png', 'webp to png', 'webp vers png'],
        'intro' => 'Le WebP est un format d’image créé par Google qui produit des fichiers légers, mais certaines applications, certains logiciels et formulaires ne l’acceptent toujours pas. Ce convertisseur WebP en PNG transforme vos images WebP en PNG, un format qui s’ouvre partout, et conserve les fonds transparents. Déposez une image ou tout un lot et téléchargez les résultats un par un ou dans un ZIP.',
        'steps' => [
            'Déposez vos images WebP dans la zone ou cliquez pour les choisir (jusqu’à 30 à la fois).',
            'Chaque image est convertie en PNG immédiatement, dans votre navigateur.',
            'Cliquez sur Télécharger à côté d’une image, ou sur Tout télécharger (ZIP).',
            'Utilisez Tout effacer pour recommencer avec d’autres images.',
        ],
        'features' => [
            'Conversion de WebP en PNG avec transparence conservée',
            'Conversion par lot jusqu’à 30 images',
            'Téléchargement en ZIP de plusieurs fichiers',
            'Accepte aussi JPG, GIF et BMP',
            '100 % privé : rien n’est envoyé',
        ],
        'content' => [
            [
                'heading' => 'Pourquoi convertir un WebP en PNG ?',
                'body' => 'Les navigateurs enregistrent beaucoup d’images du web en WebP, mais d’anciens logiciels photo, des documents bureautiques et certains formulaires n’acceptent que le PNG ou le JPG. Le PNG est sans perte et compatible partout : la conversion vous donne un fichier qui s’ouvre n’importe où sans perdre de détails. En contrepartie, un PNG est généralement plus lourd qu’un WebP.',
            ],
            [
                'heading' => 'La conversion de WebP en PNG fait-elle perdre de la qualité ?',
                'body' => 'La conversion elle-même ne fait rien perdre, car le PNG est sans perte : chaque pixel de l’image WebP est enregistré à l’identique. Si le WebP d’origine avait été compressé avec perte, cette perte reste, mais aucune nouvelle n’est ajoutée.',
            ],
        ],
        'faqs' => [
            ['q' => 'Comment convertir un WebP en PNG ?', 'a' => 'Déposez le fichier WebP dans la zone ci-dessus. Il est converti en PNG instantanément et se télécharge en un clic.'],
            ['q' => 'La transparence est-elle conservée ?', 'a' => 'Oui. Le PNG gère la transparence : les zones transparentes du WebP le restent après la conversion.'],
            ['q' => 'Pourquoi le PNG est-il plus lourd que le WebP ?', 'a' => 'Le WebP utilise une compression plus efficace. Le PNG enregistre chaque pixel sans perte, donc la même image prend généralement plus de place.'],
            ['q' => 'Mes images sont-elles envoyées ?', 'a' => 'Non. La conversion se fait dans votre navigateur avec l’API Canvas et vos images ne quittent jamais votre appareil.'],
        ],
    ],

    'png-to-jpg' => [
        'name' => 'PNG en JPG',
        'title' => 'Convertir PNG en JPG (JPEG) gratuitement',
        'description' => 'Convertissez des PNG en JPG (JPEG) en ligne gratuitement. Jusqu’à 30 images à la fois, qualité réglable et téléchargement en ZIP. Rien n’est envoyé.',
        'h1' => 'Convertir PNG en JPG',
        'tagline' => 'Convertissez des images PNG en JPG (JPEG) par lot, avec une qualité réglable.',
        'keywords' => ['png en jpg', 'convertir png en jpg', 'png en jpeg', 'convertisseur png jpg', 'png to jpg'],
        'intro' => 'Le PNG est un format sans perte idéal pour les graphismes, mais il produit des fichiers lourds, alors que le JPG (aussi appelé JPEG) est plus léger et accepté presque partout. Ce convertisseur PNG en JPG transforme une ou plusieurs images PNG en JPG avec la qualité de votre choix. Les zones transparentes deviennent blanches, car le JPG ne gère pas la transparence.',
        'steps' => [
            'Déposez vos images PNG dans la zone ou cliquez pour les choisir (jusqu’à 30 à la fois).',
            'Réglez la qualité pour des fichiers plus légers (à partir de 90 %, aucune différence visible).',
            'Chaque image est convertie en JPG immédiatement, dans votre navigateur.',
            'Téléchargez chaque JPG, ou tous ensemble dans un ZIP.',
        ],
        'features' => [
            'Conversion de PNG en JPG (JPEG) par lot',
            'Qualité JPG réglable de 50 % à 100 %',
            'Zones transparentes remplies de blanc',
            'Téléchargement en ZIP de plusieurs fichiers',
            'Privé : les images sont traitées sur votre appareil',
        ],
        'content' => [
            [
                'heading' => 'Quand convertir un PNG en JPG ?',
                'body' => 'Convertissez un PNG en JPG quand il s’agit d’une photo ou d’une image détaillée trop lourde pour un e-mail, un site ou un formulaire, ou quand un site exige du JPG. Gardez le PNG pour les logos, icônes, captures d’écran avec du texte net et tout ce qui a besoin d’un fond transparent.',
            ],
            [
                'heading' => 'JPG et JPEG, est-ce pareil ?',
                'body' => 'Oui. JPG et JPEG sont deux noms du même format ; l’extension .jpg à trois lettres vient d’anciennes versions de Windows limitées à trois caractères. Les fichiers de ce convertisseur utilisent l’extension .jpg, acceptée par tous les appareils et sites.',
            ],
        ],
        'faqs' => [
            ['q' => 'Comment convertir un PNG en JPG ?', 'a' => 'Déposez le PNG dans la zone ci-dessus : il est converti en JPG aussitôt. Cliquez sur Télécharger pour l’enregistrer.'],
            ['q' => 'Que devient le fond transparent ?', 'a' => 'Le JPG ne peut pas stocker de transparence : les zones transparentes sont remplies de blanc pendant la conversion.'],
            ['q' => 'Quelle qualité choisir ?', 'a' => 'Les 92 % par défaut donnent un résultat identique à l’original. Vers 80 %, les fichiers sont nettement plus légers avec peu de différence visible.'],
            ['q' => 'Puis-je convertir plusieurs PNG à la fois ?', 'a' => 'Oui. Déposez jusqu’à 30 images à la fois et téléchargez-les toutes ensemble dans un fichier ZIP.'],
        ],
    ],

    'jpg-to-png' => [
        'name' => 'JPG en PNG',
        'title' => 'Convertir JPG en PNG (JPEG en PNG) gratuitement',
        'description' => 'Convertissez des images JPG ou JPEG en PNG en ligne gratuitement. Sans perte, jusqu’à 30 fichiers à la fois et téléchargement en ZIP. Rien n’est envoyé.',
        'h1' => 'Convertir JPG en PNG',
        'tagline' => 'Convertissez des images JPG et JPEG en PNG sans perte, par lot.',
        'keywords' => ['jpg en png', 'jpeg en png', 'convertir jpg en png', 'convertisseur jpg png', 'jpeg to png'],
        'intro' => 'Le PNG est un format sans perte : une image enregistrée en PNG peut être modifiée et réenregistrée sans devenir plus floue. Ce convertisseur JPEG en PNG transforme vos photos JPG et JPEG en fichiers PNG, une par une ou par lots de 30, directement dans votre navigateur.',
        'steps' => [
            'Déposez vos images JPG ou JPEG dans la zone ou cliquez pour les choisir.',
            'Chaque image est convertie en PNG immédiatement.',
            'Cliquez sur Télécharger à côté d’une image, ou sur Tout télécharger (ZIP).',
            'Utilisez Tout effacer pour convertir un autre lot.',
        ],
        'features' => [
            'Conversion de JPG et JPEG en PNG sans perte',
            'Conversion par lot jusqu’à 30 images',
            'Téléchargement en ZIP de plusieurs fichiers',
            'Accepte aussi WebP, GIF et BMP',
            'Privé : rien n’est envoyé',
        ],
        'content' => [
            [
                'heading' => 'Pourquoi convertir un JPG en PNG ?',
                'body' => 'Passez au PNG quand vous allez modifier une image plusieurs fois, l’intégrer à une création graphique ou quand un site ou une application demande du PNG. À chaque enregistrement, un JPG perd un peu de qualité ; un PNG non, c’est donc un format de travail plus sûr.',
            ],
            [
                'heading' => 'L’image sera-t-elle transparente ou plus nette ?',
                'body' => 'Non. La conversion garde l’image telle quelle : un JPG n’a pas de transparence à conserver, et les détails perdus par la compression JPG ne peuvent pas être récupérés. Le PNG sera aussi généralement plus lourd que le JPG, car il enregistre chaque pixel sans perte.',
            ],
        ],
        'faqs' => [
            ['q' => 'Comment convertir un JPG en PNG ?', 'a' => 'Déposez le JPG dans la zone ci-dessus. Il est converti en PNG aussitôt et se télécharge en un clic.'],
            ['q' => 'Y a-t-il une différence entre JPG et JPEG ?', 'a' => 'Non. Ce sont deux noms du même format, et les deux se convertissent de la même façon.'],
            ['q' => 'Pourquoi le fichier PNG est-il plus lourd ?', 'a' => 'Le PNG est sans perte : il conserve chaque pixel. Le JPG gagne de la place en supprimant des détails, d’où des fichiers plus légers.'],
            ['q' => 'Mes photos sont-elles envoyées ?', 'a' => 'Non. Tout se passe dans votre navigateur et vos photos ne quittent jamais votre appareil.'],
        ],
    ],

    'merge-pdf' => [
        'name' => 'Fusionner des PDF',
        'title' => 'Fusionner PDF : combiner des fichiers PDF gratuitement',
        'description' => 'Fusionnez des fichiers PDF en un seul document, gratuitement. Réorganisez l’ordre, sans filigrane ni inscription. Rien n’est envoyé.',
        'h1' => 'Fusionner des fichiers PDF en ligne',
        'tagline' => 'Combinez plusieurs PDF en un seul fichier, sans filigrane et sans envoi.',
        'keywords' => ['fusionner pdf', 'combiner pdf', 'assembler des pdf', 'fusion pdf', 'fusionner pdf en ligne gratuit'],
        'intro' => 'Fusionner des PDF consiste à réunir plusieurs fichiers PDF en un seul document. Combinez plusieurs fichiers PDF en un seul document, dans l’ordre de votre choix. Contrairement à beaucoup de sites PDF, vos fichiers sont fusionnés dans votre navigateur : les documents confidentiels ne passent jamais par un serveur, et le résultat n’a pas de filigrane.',
        'steps' => [
            'Ajoutez deux fichiers PDF ou plus en les déposant ou en cliquant pour parcourir.',
            'Mettez-les dans le bon ordre avec les flèches haut et bas.',
            'Cliquez sur Fusionner les PDF.',
            'Téléchargez votre PDF combiné.',
        ],
        'features' => [
            'Fusionnez jusqu’à 50 fichiers PDF à la fois',
            'Réorganisez ou retirez des fichiers avant la fusion',
            'Affiche le nombre de pages de chaque fichier',
            'Sans filigrane ni limite de pages',
            'Privé : les fichiers ne quittent jamais votre appareil',
        ],
        'content' => [
            [
                'heading' => 'Pourquoi fusionner des PDF ?',
                'body' => 'Beaucoup de candidatures, de demandes de visa et de portails universitaires n’acceptent qu’un seul fichier. Fusionner votre CV, votre lettre de motivation et vos certificats en un seul PDF garde tout ensemble et dans le bon ordre.',
            ],
            [
                'heading' => 'Puis-je fusionner un PDF protégé par mot de passe ?',
                'body' => 'Les PDF chiffrés ne peuvent pas être fusionnés tant que la protection n’est pas retirée. Ouvrez le fichier dans votre lecteur PDF avec le mot de passe, enregistrez ou imprimez une copie sans protection, puis fusionnez cette copie.',
            ],
        ],
        'faqs' => [
            ['q' => 'Est-il sûr de fusionner des PDF ici ?', 'a' => 'Oui. Les fichiers sont traités localement dans votre navigateur avec JavaScript et ne sont jamais envoyés : ils restent totalement privés.'],
            ['q' => 'Y a-t-il un filigrane ?', 'a' => 'Non. Le PDF fusionné n’a ni filigrane, ni logo, ni pages ajoutées.'],
            ['q' => 'Combien de PDF puis-je fusionner ?', 'a' => 'Jusqu’à 50 fichiers à la fois. La limite pratique dépend de la mémoire de votre appareil, et la plupart gèrent facilement quelques centaines de pages.'],
            ['q' => 'Les liens et signets sont-ils conservés ?', 'a' => 'Le contenu des pages, les images et le texte sont conservés à l’identique. Certaines fonctions interactives, comme les signets et les champs de formulaire, peuvent ne pas être reprises.'],
            ['q' => 'Fusionner des PDF ici est-il entièrement gratuit ?', 'a' => 'Oui. Il n’y a aucun coût, aucune limite de fichiers, aucun compte ni inscription : vous pouvez fusionner des PDF en ligne gratuitement autant de fois que vous le souhaitez, directement dans votre navigateur.'],
        ],
    ],

    'split-pdf' => [
        'name' => 'Diviser un PDF',
        'title' => 'Diviser PDF : extraire des pages d’un PDF gratuitement',
        'description' => 'Divisez un PDF en plusieurs fichiers ou extrayez des pages en ligne. Choisissez des plages comme 1-3, 5. Gratuit, sans envoi ni filigrane.',
        'h1' => 'Diviser un PDF et extraire des pages',
        'tagline' => 'Extrayez des pages ou divisez un PDF en fichiers séparés, en toute confidentialité dans votre navigateur.',
        'keywords' => ['diviser pdf', 'extraire des pages pdf', 'séparer les pages d’un pdf', 'découper un pdf', 'diviser pdf en ligne'],
        'intro' => 'Diviser un PDF consiste à extraire des pages d’un document ou à le découper en plusieurs PDF plus petits. Récupérez uniquement les pages dont vous avez besoin dans un PDF, ou divisez-le en plusieurs fichiers. Saisissez des plages comme 1-3, 5, 8-10, ou séparez chaque page dans son propre PDF. Tout le traitement se fait dans votre navigateur.',
        'steps' => [
            'Choisissez le PDF à diviser.',
            'Choisissez un mode : extraire des pages dans un PDF, diviser par plages ou séparer chaque page.',
            'Saisissez les plages de pages, par exemple 1-3, 5, 8-10.',
            'Cliquez sur Diviser le PDF et téléchargez le résultat (plusieurs fichiers arrivent dans un ZIP).',
        ],
        'features' => [
            'Extraire les pages choisies dans un nouveau PDF',
            'Diviser selon des plages personnalisées en fichiers séparés',
            'Séparer chaque page dans son propre PDF',
            'Plusieurs fichiers regroupés dans un ZIP',
            'Sans filigrane, sans envoi',
        ],
        'content' => [
            [
                'heading' => 'Comment écrire des plages de pages',
                'body' => 'Séparez les plages par des virgules. Utilisez un tiret pour une série de pages, comme 1-5, ou un seul nombre pour une page. Par exemple, « 1-3, 7, 10-12 » sélectionne les pages 1, 2, 3, 7, 10, 11 et 12.',
            ],
        ],
        'faqs' => [
            ['q' => 'Comment extraire une page d’un PDF ?', 'a' => 'Choisissez « Extraire des pages », saisissez le numéro de page (par exemple 4) et cliquez sur Diviser le PDF. Vous obtenez un nouveau PDF contenant uniquement cette page.'],
            ['q' => 'Puis-je séparer chaque page dans un fichier distinct ?', 'a' => 'Oui. Choisissez « Séparer chaque page » et vous obtenez un ZIP avec un PDF par page.'],
            ['q' => 'Mes fichiers sont-ils envoyés ?', 'a' => 'Non. Le PDF est divisé localement dans votre navigateur et ne quitte jamais votre appareil.'],
            ['q' => 'La division réduit-elle la qualité ?', 'a' => 'Non. Les pages sont copiées telles quelles : le texte et les images gardent leur qualité d’origine.'],
        ],
    ],

    'age-calculator' => [
        'name' => 'Calculateur d’âge',
        'title' => 'Calcul d’âge : votre âge en jours, mois et années',
        'description' => 'Indiquez votre date de naissance pour connaître votre âge exact en jours, mois et années, avec le compte à rebours de votre anniversaire. Gratuit.',
        'h1' => 'Calculateur d’âge',
        'tagline' => 'Trouvez votre âge exact en années, mois et jours, et votre prochain anniversaire.',
        'keywords' => ['calculateur d’âge', 'calculer son âge', 'calcul date de naissance', 'quel âge ai-je', 'calcul âge avec date de naissance'],
        'intro' => 'Un calculateur d’âge calcule l’âge exact d’une personne, en années, mois et jours, à partir de sa date de naissance. Saisissez une date de naissance pour connaître l’âge exact en années, mois et jours. Vous obtenez aussi le nombre total de mois, semaines, jours et heures vécus, le jour de la semaine de votre naissance et un compte à rebours jusqu’à votre prochain anniversaire. Vous pouvez aussi calculer un âge à n’importe quelle date passée ou future.',
        'steps' => [
            'Saisissez la date de naissance.',
            'Gardez aujourd’hui comme date « âge à la date du » ou choisissez-en une autre.',
            'Voyez instantanément l’âge exact et les détails.',
        ],
        'features' => [
            'Âge exact en années, mois et jours',
            'Total de mois, semaines, jours et heures',
            'Compte à rebours jusqu’au prochain anniversaire',
            'Jour de la semaine de votre naissance',
            'Gère les années bissextiles et les anniversaires du 29 février',
        ],
        'content' => [
            [
                'heading' => 'Comment l’âge est calculé',
                'body' => 'Le calculateur compte d’abord les années complètes, puis les mois complets, puis les jours restants, selon la même méthode que les formulaires officiels. Les années bissextiles sont gérées automatiquement, et les personnes nées un 29 février fêtent leur anniversaire le 28 février les années non bissextiles.',
            ],
        ],
        'faqs' => [
            ['q' => 'Comment calculer mon âge exact ?', 'a' => 'Saisissez votre date de naissance : le calculateur affiche votre âge en années, mois et jours à la date d’aujourd’hui, ou à toute date de votre choix.'],
            ['q' => 'Puis-je calculer un âge à une date précise ?', 'a' => 'Oui. Changez la date « Âge à la date du » pour voir l’âge qu’une personne avait ou aura ce jour-là, pratique pour les inscriptions scolaires et les conditions d’âge des concours.'],
            ['q' => 'Comment les années bissextiles sont-elles gérées ?', 'a' => 'Elles sont comptées exactement. Pour un anniversaire le 29 février, le prochain anniversaire d’une année non bissextile s’affiche au 28 février.'],
            ['q' => 'Ma date de naissance est-elle enregistrée ?', 'a' => 'Non. Le calcul se fait dans votre navigateur et rien n’est enregistré ni envoyé.'],
            ['q' => 'Comment calculer l’âge à partir de la date de naissance ?', 'a' => 'Le calculateur d’âge utilise votre date de naissance pour déterminer votre âge exact en années, mois et jours : il suffit de la saisir pour voir le résultat instantanément.'],
        ],
    ],

    'percentage-calculator' => [
        'name' => 'Calculateur de pourcentage',
        'title' => 'Calcul de pourcentage avec formule : % et variation',
        'description' => 'Calcul de pourcentage gratuit avec la formule affichée pour chaque résultat : X % de Y, quel pourcentage X représente de Y, hausse ou baisse et plus.',
        'h1' => 'Calculateur de pourcentage',
        'tagline' => 'Tous les calculs de pourcentage courants au même endroit, avec la formule.',
        'keywords' => ['calcul pourcentage', 'calculateur de pourcentage', 'calcul de variation en pourcentage', 'calcul augmentation pourcentage', 'quel pourcentage de'],
        'intro' => 'Un calculateur de pourcentage calcule des pourcentages, comme X % de Y ou la variation en pourcentage entre deux nombres. Calculez des pourcentages en un instant : combien font 15 % de 200, quel pourcentage 30 représente de 120, la hausse en pourcentage de 80 à 100, et plus encore. Chaque calculateur affiche la formule utilisée pour vérifier le calcul, pour les devoirs, remises, pourboires, notes et rapports.',
        'steps' => [
            'Trouvez le calculateur qui correspond à votre question.',
            'Saisissez vos nombres dans les cases.',
            'Lisez la réponse et la formule juste en dessous.',
        ],
        'features' => [
            'Combien font X % de Y',
            'X représente quel pourcentage de Y',
            'Hausse ou baisse en pourcentage de X à Y',
            'X représente Y % de quel nombre',
            'Augmenter ou diminuer un nombre d’un pourcentage',
            'Formule affichée pour chaque réponse',
        ],
        'content' => [
            [
                'heading' => 'Quelle est la formule pour calculer un pourcentage ?',
                'body' => 'X % de Y = (X / 100) x Y. X en pourcentage de Y = (X / Y) x 100. Variation en pourcentage de A à B = ((B - A) / |A|) x 100. Un résultat positif est une hausse, un résultat négatif une baisse.',
            ],
        ],
        'faqs' => [
            ['q' => 'Comment calculer un pourcentage d’un nombre ?', 'a' => 'Divisez le pourcentage par 100 et multipliez par le nombre. Par exemple, 15 % de 200 = 0,15 x 200 = 30.'],
            ['q' => 'Comment calculer une hausse en pourcentage ?', 'a' => 'Soustrayez l’ancienne valeur de la nouvelle, divisez par l’ancienne valeur et multipliez par 100. De 80 à 100 : (100 - 80) / 80 x 100 = 25 %.'],
            ['q' => 'Comment calculer une remise ?', 'a' => 'Utilisez « Diminuer un nombre d’un pourcentage ». Pour 20 % de remise sur 50 €, le prix soldé est 50 € x (1 - 0,20) = 40 €.'],
            ['q' => 'Un « calculateur de pourcentage » est-il la même chose qu’une « calculatrice de pourcentage » ?', 'a' => 'Oui, les deux désignent le même outil. Il calcule la hausse, la baisse ou la variation en pourcentage entre deux nombres quelconques, directement dans le navigateur et sans rien télécharger.'],
            ['q' => 'Puis-je calculer un pourcentage en ligne sans rien télécharger ?', 'a' => 'Oui. Tout se passe dans votre navigateur : saisissez les nombres et le résultat avec la formule s’affiche instantanément, sans application, inscription ni envoi de fichier.'],
        ],
        'table' => [
            'caption' => 'Formules de pourcentage avec exemples',
            'headers' => ['Question', 'Formule', 'Exemple'],
            'rows' => [
                ['Combien font X % de Y ?', '(X / 100) × Y', '15 % de 200 = 30'],
                ['X représente quel % de Y ?', '(X / Y) × 100', '30 sur 120 = 25 %'],
                ['Variation en % de A à B', '(B − A) / |A| × 100', '80 → 100 = +25 %'],
                ['Augmenter Y de X %', 'Y × (1 + X / 100)', '50 + 20 % = 60'],
                ['Diminuer Y de X %', 'Y × (1 − X / 100)', '50 − 20 % = 40'],
            ],
        ],
    ],

    'tip-calculator' => [
        'name' => 'Calculateur de pourboire',
        'title' => 'Calculateur de pourboire - partagez l’addition',
        'description' => 'Calculateur de pourboire gratuit : indiquez l’addition, choisissez un pourcentage de pourboire et partagez le total entre plusieurs personnes. Instantané.',
        'h1' => 'Calculateur de pourboire',
        'tagline' => 'Calculez le pourboire et partagez l’addition entre n’importe quel nombre de personnes.',
        'keywords' => ['calculateur de pourboire', 'partager l’addition', 'comment calculer le pourboire', 'calcul du pourboire par personne', 'pourboire restaurant'],
        'intro' => 'Un calculateur de pourboire calcule combien laisser de pourboire sur une addition et partage le pourboire et le total entre n’importe quel nombre de personnes. Indiquez le montant de l’addition, choisissez un pourcentage de pourboire (15 %, 18 %, 20 % et 25 % sont les plus courants, ou saisissez le vôtre) et le nombre de personnes qui partagent l’addition. Le calculateur affiche instantanément le pourboire, le total avec le pourboire inclus et ce que chaque personne doit payer, avec une option pour arrondir le montant par personne à l’euro supérieur afin que personne n’ait besoin de faire l’appoint.',
        'steps' => [
            'Indiquez le montant de l’addition avant le pourboire.',
            'Choisissez un pourcentage de pourboire prédéfini ou saisissez le vôtre.',
            'Indiquez le nombre de personnes qui partagent l’addition (laissez 1 si personne ne la partage).',
            'Activez « Arrondir » si vous voulez que chaque personne paie un montant rond.',
            'Lisez le pourboire, le total et les montants par personne ci-dessous.',
        ],
        'features' => [
            'Pourcentages de pourboire prédéfinis (15 %, 18 %, 20 %, 25 %) et tout pourcentage personnalisé',
            'Partage le pourboire et le total à parts égales entre n’importe quel nombre de personnes',
            'Arrondi optionnel pour que le montant par personne soit un chiffre rond',
            'Affiche le calcul derrière chaque résultat',
            'Fonctionne entièrement dans votre navigateur : rien de ce que vous saisissez n’est envoyé',
        ],
        'content' => [
            [
                'heading' => 'Combien faut-il laisser de pourboire ?',
                'body' => 'Aux États-Unis, 15-20 % de l’addition est la fourchette la plus courante pour le pourboire au restaurant, avec 20 % pour un bon service, 15 % pour un service normal et 10 % ou moins pour un service médiocre. La livraison, les taxis et les salons utilisent souvent des pourcentages plus bas, en général 10-15 %. Le montant juste dépend toujours de l’usage local et du service reçu, les boutons prédéfinis sont donc un point de départ, pas une règle.',
            ],
            [
                'heading' => 'Partager une addition entre un groupe',
                'body' => 'Régler « Nombre de personnes » sur plus d’une partage le pourboire et le total à parts égales, la façon la plus simple de diviser une addition commune. Cela ne tient pas compte du fait que chacun ait commandé des montants différents ; dans ce cas, calculez d’abord ce que chacun a commandé et n’utilisez ce calculateur que pour un pourboire qui doit vraiment être partagé à parts égales, comme une entrée partagée ou un pourboire de groupe.',
            ],
        ],
        'faqs' => [
            ['q' => 'Combien dois-je laisser de pourboire au restaurant ?', 'a' => 'Aux États-Unis, 15-20 % de l’addition avant taxes est la fourchette la plus courante, avec 20 % pour un bon service. Utilisez un bouton prédéfini ou saisissez votre propre pourcentage.'],
            ['q' => 'Le pourboire se calcule-t-il avant ou après les taxes ?', 'a' => 'La plupart des guides recommandent de calculer le pourboire sur le sous-total avant taxes, même si le calculer sur le total taxes incluses est aussi courant et n’ajoute qu’un petit montant.'],
            ['q' => 'Comment partager une addition entre amis ?', 'a' => 'Indiquez l’addition et le pourcentage de pourboire, puis réglez « Nombre de personnes » selon le nombre de personnes qui la partagent. Le pourboire et le total sont divisés à parts égales entre elles.'],
            ['q' => 'Que fait « Arrondir » ?', 'a' => 'Cela arrondit ce que chaque personne paie au chiffre rond supérieur, afin que personne n’ait besoin de faire l’appoint. La différence est ajoutée au pourboire.'],
            ['q' => 'Ce calculateur de pourboire est-il gratuit ?', 'a' => 'Oui. Il est gratuit, sans inscription, et tout est calculé dans votre navigateur.'],
        ],
        'table' => [
            'caption' => 'Montant du pourboire sur une addition de 50 €',
            'headers' => ['Pourboire %', 'Montant du pourboire', 'Total avec pourboire'],
            'rows' => [
                ['15 %', '7,50 €', '57,50 €'],
                ['18 %', '9,00 €', '59,00 €'],
                ['20 %', '10,00 €', '60,00 €'],
                ['25 %', '12,50 €', '62,50 €'],
            ],
        ],
    ],

    'json-formatter' => [
        'name' => 'Formateur JSON',
        'title' => 'Formateur et validateur JSON : embellir du JSON en ligne',
        'description' => 'Formatez, validez et minifiez du JSON en ligne gratuitement. Erreurs indiquées à la ligne et à la colonne près. Rapide et privé, sans envoi.',
        'h1' => 'Formateur et validateur JSON',
        'tagline' => 'Embellissez, validez et minifiez du JSON avec des messages d’erreur clairs.',
        'keywords' => ['formateur json', 'validateur json', 'embellir json', 'formater json', 'minifier json'],
        'intro' => 'Un formateur JSON est un outil qui rend les données JSON lisibles grâce aux retours à la ligne et à l’indentation, et vérifie qu’elles sont valides. Collez du JSON pour l’embellir avec une indentation propre, le valider ou le minifier pour la production. Si le JSON est invalide, vous obtenez un message d’erreur clair avec la ligne et la colonne exactes pour le corriger vite. Vos données sont traitées localement et ne sont jamais envoyées.',
        'steps' => [
            'Collez votre JSON dans la zone d’entrée ou cliquez sur Exemple.',
            'Cliquez sur Formater pour embellir ou sur Minifier pour compacter.',
            'Corrigez les erreurs grâce à la ligne et à la colonne indiquées.',
            'Copiez ou téléchargez le résultat.',
        ],
        'features' => [
            'Embellissement avec 2 espaces, 4 espaces ou tabulations',
            'Minification du JSON sur une seule ligne',
            'Validation avec la ligne et la colonne de l’erreur',
            'Tri alphabétique des clés en option',
            'Copie et téléchargement en .json',
        ],
        'content' => [
            [
                'heading' => 'Quelles sont les erreurs JSON les plus courantes ?',
                'body' => 'Les erreurs les plus fréquentes sont les virgules en trop après le dernier élément, les apostrophes au lieu des guillemets doubles, les clés sans guillemets et les commentaires, qui sont tous interdits en JSON standard.',
            ],
        ],
        'faqs' => [
            ['q' => 'Mon JSON est-il envoyé à un serveur ?', 'a' => 'Non. Le formatage et la validation se font dans votre navigateur : les clés d’API et données privées restent sur votre machine.'],
            ['q' => 'Quelle différence entre formater et minifier ?', 'a' => 'Formater ajoute des retours à la ligne et une indentation pour rendre le JSON lisible. Minifier supprime tous les espaces inutiles pour rendre le fichier le plus léger possible.'],
            ['q' => 'Pourquoi mon JSON affiche-t-il une erreur ?', 'a' => 'Vérifiez la ligne et la colonne indiquées dans le message. Les virgules en trop, les apostrophes et les guillemets manquants autour des clés sont les causes habituelles.'],
            ['q' => 'Peut-il traiter de gros fichiers ?', 'a' => 'Oui. Des fichiers de plusieurs mégaoctets sont formatés en bien moins d’une seconde sur la plupart des appareils.'],
        ],
        'table' => [
            'caption' => 'Erreurs JSON courantes et comment les corriger',
            'headers' => ['Problème', 'Invalide', 'Valide'],
            'rows' => [
                ['Virgule en trop', '{"a": 1,}', '{"a": 1}'],
                ['Apostrophes', '{\'a\': 1}', '{"a": 1}'],
                ['Clé sans guillemets', '{a: 1}', '{"a": 1}'],
                ['Commentaire', '{"a": 1 // note}', '{"a": 1}'],
            ],
        ],
    ],

    'base64-encoder-decoder' => [
        'name' => 'Encoder / décoder Base64',
        'title' => 'Encoder et décoder du Base64 en ligne : texte et fichiers',
        'description' => 'Encodez du texte ou des fichiers en Base64 et décodez le Base64 en texte. UTF-8 et Base64 compatible URL. Gratuit, rapide et privé.',
        'h1' => 'Encodeur et décodeur Base64',
        'tagline' => 'Encodez et décodez du texte et des fichiers en Base64, avec UTF-8 et variante compatible URL.',
        'keywords' => ['encoder base64', 'décoder base64', 'convertisseur base64', 'base64 en texte', 'image en base64'],
        'intro' => 'Le Base64 permet d’écrire n’importe quelle donnée, y compris des fichiers, avec seulement 64 caractères de texte ; encoder convertit en Base64 et décoder fait l’inverse. Convertissez du texte en Base64 ou décodez du Base64 en texte lisible, avec une prise en charge complète des emojis et des caractères non latins. Vous pouvez aussi transformer un fichier ou une image en data URL Base64 à intégrer dans du HTML, du CSS ou du JSON.',
        'steps' => [
            'Choisissez le mode Texte ou Fichier.',
            'Pour du texte, collez votre entrée et cliquez sur Encoder ou Décoder.',
            'Pour un fichier, choisissez-le pour obtenir sa chaîne Base64 ou sa data URL.',
            'Copiez le résultat.',
        ],
        'features' => [
            'Encodage et décodage de texte avec prise en charge complète de l’UTF-8',
            'Option Base64 compatible URL (- et _ au lieu de + et /)',
            'Fichier et image vers Base64 ou data URL',
            'Message d’erreur clair pour un Base64 invalide',
            'Fonctionne localement : rien n’est envoyé',
        ],
        'content' => [
            [
                'heading' => 'Qu’est-ce que le Base64 ?',
                'body' => 'Le Base64 représente des données binaires avec 64 caractères texte sûrs (A-Z, a-z, 0-9, + et /). Il sert à intégrer des images dans du HTML et du CSS, à envoyer des pièces jointes par e-mail et à transmettre des données dans des URL et des API. Le Base64 est un encodage, pas un chiffrement : il ne protège pas les données.',
            ],
        ],
        'faqs' => [
            ['q' => 'Le Base64 est-il un chiffrement ?', 'a' => 'Non. N’importe qui peut décoder du Base64. Utilisez-le pour transporter des données, jamais pour protéger des mots de passe ou des secrets.'],
            ['q' => 'Qu’est-ce que le Base64 compatible URL ?', 'a' => 'Une variante qui remplace + par - et / par _, et supprime généralement le remplissage =, pour que la chaîne puisse être utilisée sans risque dans des URL et des noms de fichiers.'],
            ['q' => 'Pourquoi le Base64 est-il plus lourd que l’original ?', 'a' => 'Le Base64 transforme chaque groupe de 3 octets en 4 caractères : les données encodées sont environ 33 % plus lourdes que l’original.'],
            ['q' => 'Comment convertir une image en Base64 ?', 'a' => 'Passez en mode Fichier et choisissez votre image. Vous obtenez la chaîne Base64 brute et une data URL prête à l’emploi.'],
        ],
        'table' => [
            'caption' => 'De combien le Base64 alourdit les données',
            'headers' => ['Taille d’origine', 'Longueur en Base64'],
            'rows' => [
                ['3 octets', '4 caractères'],
                ['1 Ko (1 024 octets)', '1 368 caractères'],
                ['1 Mo (1 048 576 octets)', '1 398 104 caractères'],
            ],
        ],
    ],

    'what-is-my-ip' => [
        'name' => 'Quelle est mon IP',
        'title' => 'Quelle est mon adresse IP ? Voir mon IP publique',
        'description' => 'Voyez votre adresse IP publique, en IPv4 ou IPv6, ainsi que votre navigateur, système, écran et fuseau horaire. Recherche d’IP gratuite.',
        'h1' => 'Quelle est mon adresse IP ?',
        'tagline' => 'Votre adresse IP publique et les détails de votre navigateur, instantanément.',
        'keywords' => ['quelle est mon ip', 'mon adresse ip', 'recherche adresse ip', 'vérifier mon ip', 'quelle est mon adresse ip'],
        'intro' => 'Une adresse IP est le numéro qui identifie votre connexion sur Internet ; votre IP publique est celle que voient les sites. Votre adresse IP publique est l’adresse que voient les sites quand vous vous connectez à Internet. Elle est attribuée par votre fournisseur d’accès, ou par votre VPN si vous en utilisez un. Ci-dessous, vous voyez votre adresse IP actuelle, si elle est en IPv4 ou en IPv6, et des détails sur votre navigateur et votre appareil.',
        'steps' => [
            'Ouvrez cette page : votre adresse IP s’affiche en haut.',
            'Cliquez sur Copier pour la copier dans le presse-papiers.',
            'Activez ou désactivez un VPN et cliquez sur Actualiser pour voir votre IP changer.',
        ],
        'features' => [
            'Adresse IP publique copiable en un clic',
            'Détection IPv4 ou IPv6',
            'Navigateur, système d’exploitation et type d’appareil',
            'Résolution d’écran, langue et fuseau horaire',
            'Actualisez pour vérifier que votre VPN fonctionne',
        ],
        'content' => [
            [
                'heading' => 'IPv4 ou IPv6',
                'body' => 'Les adresses IPv4 ressemblent à 203.0.113.42 et il n’en existe qu’environ 4,3 milliards. Les adresses IPv6, comme 2001:db8::1, ont été créées parce que les adresses IPv4 venaient à manquer. Beaucoup de connexions prennent désormais en charge les deux.',
            ],
            [
                'heading' => 'Quelle est mon adresse IP publique ?',
                'body' => 'Votre adresse IP publique est celle affichée en haut de cette page : l’adresse que voit n’importe quel site ou service quand vous vous connectez, partagée par tout votre réseau domestique. Votre box attribue ensuite à chaque appareil de ce réseau sa propre adresse IP privée (souvent 192.168.x.x), invisible depuis l’extérieur d’Internet.',
            ],
        ],
        'faqs' => [
            ['q' => 'À quoi sert mon adresse IP ?', 'a' => 'Les sites et services utilisent votre adresse IP pour vous renvoyer des données. Elle peut aussi révéler votre ville approximative et votre fournisseur d’accès.'],
            ['q' => 'Pourquoi mon adresse IP change-t-elle ?', 'a' => 'La plupart des fournisseurs d’accès attribuent des adresses IP dynamiques qui peuvent changer au redémarrage de la box. Les IP des données mobiles changent souvent.'],
            ['q' => 'Comment masquer mon adresse IP ?', 'a' => 'Utilisez un VPN ou un réseau d’anonymisation comme Tor. Les sites voient alors l’adresse IP du VPN à la place de la vôtre.'],
            ['q' => 'Conservez-vous mon adresse IP ?', 'a' => 'Non. Cet outil affiche seulement votre adresse IP et ne l’enregistre dans aucune base de données.'],
            ['q' => 'Comment trouver mon adresse IP publique ?', 'a' => 'Ouvrez simplement cette page : votre adresse IP publique s’affiche en haut instantanément, sans inscription, téléchargement ni clic supplémentaire. Vous voyez si c’est une adresse IPv4 (comme 203.0.113.42) ou IPv6 : exactement le numéro que voient les autres sites et services quand vous vous connectez.'],
        ],
    ],

    'dice-roller' => [
        'name' => 'Lanceur de dés',
        'title' => 'Lanceur de dés : lancer des dés virtuels en ligne (D6, D20…)',
        'description' => 'Lancez de 1 à 10 dés virtuels en ligne : D4, D6, D8, D10, D12, D20 ou D100. Résultats équitables, animation 3D, total et historique.',
        'h1' => 'Lanceur de dés',
        'tagline' => 'Lancez jusqu’à 10 dés, du D4 au D100, avec animation 3D et total.',
        'keywords' => ['lancer de dés', 'lancer des dés en ligne', 'dés virtuels', 'lanceur d20', 'dé aléatoire'],
        'intro' => 'Un lanceur de dés est un outil en ligne qui simule un lancer de dés et donne un résultat aléatoire pour chaque dé. Vous avez perdu les dés d’un jeu de société ou il vous faut un D20 pour un jeu de rôle ? Ce lanceur de dés gratuit lance jusqu’à dix dés virtuels à la fois avec une animation 3D réaliste. Choisissez un dé classique à six faces ou n’importe quel dé polyédrique du D4 au D100, et voyez chaque valeur, le total et vos derniers lancers instantanément.',
        'steps' => [
            'Choisissez le type de dé : D4, D6, D8, D10, D12, D20 ou D100.',
            'Choisissez le nombre de dés, de 1 à 10.',
            'Appuyez sur Lancer (ou touchez les dés, ou appuyez sur R).',
            'Lisez chaque valeur et le total. Les lancers précédents sont gardés dans l’historique.',
        ],
        'features' => [
            'Sept types de dés : D4, D6, D8, D10, D12, D20 et D100',
            'Jusqu’à 10 dés à la fois avec total automatique',
            'Dés à six faces en 3D avec de vrais points',
            'Résultats équitables grâce au générateur aléatoire sécurisé du navigateur',
            'Historique des lancers et raccourcis clavier (R, Espace ou Entrée)',
        ],
        'content' => [
            [
                'heading' => 'Un lanceur de dés en ligne est-il équitable ?',
                'body' => 'Oui. Chaque lancer utilise la Web Crypto API de votre navigateur, la même source d’aléa que pour créer des mots de passe et des clés de chiffrement. Chaque face a exactement la même probabilité de sortir, et le résultat est déterminé avant le début de l’animation, qui ne peut donc pas l’influencer. Les dés physiques, eux, peuvent être légèrement déséquilibrés par leurs arêtes arrondies ou leurs points creusés.',
            ],
            [
                'heading' => 'Quels dés utilisent les jeux ?',
                'body' => 'La plupart des jeux de société familiaux, comme le Monopoly, les Petits Chevaux et le Yams, utilisent des dés à six faces (D6). Les jeux de rôle comme Donjons & Dragons utilisent un jeu complet de dés polyédriques : D4, D6, D8, D10, D12 et D20, avec deux D10 ou un D100 pour les jets de pourcentage. Ici, vous passez de l’un à l’autre en un clic.',
            ],
        ],
        'faqs' => [
            ['q' => 'Combien de dés puis-je lancer à la fois ?', 'a' => 'De 1 à 10 dés en même temps. Le lanceur affiche chaque valeur et calcule le total pour vous.'],
            ['q' => 'Les lancers sont-ils vraiment aléatoires ?', 'a' => 'Oui. Ils utilisent le générateur de nombres aléatoires cryptographiquement sûr de votre navigateur : chaque face a la même probabilité et les résultats sont imprévisibles.'],
            ['q' => 'Puis-je lancer un D20 pour Donjons & Dragons ?', 'a' => 'Oui. Choisissez D20 parmi les types de dés et appuyez sur Lancer. Les D4, D8, D10, D12 et D100 sont aussi disponibles.'],
            ['q' => 'Puis-je lancer les dés sans animation ?', 'a' => 'Si votre appareil est réglé pour réduire les animations, les résultats s’affichent instantanément sans animation.'],
            ['q' => 'Qu’est-ce qu’un jet de dés en ligne ?', 'a' => 'Un jet de dés (ou lancé de dés) en ligne reproduit un lancer réel sans rien à lancer : ce générateur de dés en ligne utilise le générateur aléatoire sécurisé de votre navigateur pour afficher aussitôt un résultat équitable, comme un dé en ligne classique. « Dé virtuel » et « dé numérique » désignent le même outil. Pour un dé classique, choisissez D6 dans le type de dé.'],
        ],
        'table' => [
            'caption' => 'Types de dés et leurs usages',
            'headers' => ['Dé', 'Faces', 'Usage courant'],
            'rows' => [
                ['D4', '4', 'Petits jets de dégâts dans les jeux de rôle'],
                ['D6', '6', 'Jeux de société comme le Monopoly ou les Petits Chevaux'],
                ['D8, D10, D12', '8, 10, 12', 'Jets de dégâts et de compétence dans les jeux de rôle'],
                ['D20', '20', 'Jets d’attaque et tests dans Donjons & Dragons'],
                ['D100', '100', 'Jets de pourcentage'],
            ],
        ],
    ],

    'coin-flip' => [
        'name' => 'Pile ou face',
        'title' => 'Générateur Pile ou Face : lancer une pièce en ligne',
        'description' => 'Générateur de pile ou face en ligne avec animation 3D réaliste. Lancez jusqu’à 100 pièces à la fois et suivez totaux et séries. Gratuit, sans inscription.',
        'h1' => 'Pile ou face',
        'tagline' => 'Pile ou face ? Lancez une pièce en 3D, ou jusqu’à 100 à la fois, et voyez les stats.',
        'keywords' => ['pile ou face', 'lancer une pièce', 'pile ou face en ligne', 'tirage pile ou face', 'pièce virtuelle'],
        'intro' => 'Pile ou face est une façon rapide de choisir au hasard entre deux options, chacune avec 50 % de chances. Tranchez une décision, choisissez qui commence ou faites une expérience de probabilité avec ce pile ou face en ligne gratuit. Lancez une pièce 3D qui tournoie dans les airs, ou jusqu’à 100 pièces à la fois. L’outil tient le compte des faces et des piles, la répartition en pourcentage et votre série en cours.',
        'steps' => [
            'Choisissez combien de pièces lancer : 1, 2, 5, 10, 25 ou 100.',
            'Appuyez sur Lancer (ou touchez la pièce, ou appuyez sur F).',
            'Voyez le résultat, les totaux, la répartition face/pile et votre série.',
            'Appuyez sur Réinitialiser les stats pour recommencer une expérience.',
        ],
        'features' => [
            'Animation 3D réaliste de la pièce',
            'Jusqu’à 100 pièces en un seul lancer',
            'Totaux, répartition en pourcentage et série en cours',
            'Chances exactes de 50/50 grâce à un aléa sécurisé',
            'Raccourci clavier : F, Espace ou Entrée',
        ],
        'content' => [
            [
                'heading' => 'Pile ou face, est-ce vraiment 50/50 ?',
                'body' => 'Ici, le lancer virtuel est exactement 50/50 : chaque résultat vient du générateur aléatoire sécurisé de votre navigateur, sans mémoire des lancers précédents. Les vraies pièces ont un très léger biais vers la face tournée vers le haut au lancer, mesuré par des chercheurs à environ 51 %. Des séries de cinq ou six fois le même côté sont normales et ne veulent pas dire que la pièce est truquée.',
            ],
            [
                'heading' => 'Des façons amusantes d’utiliser pile ou face',
                'body' => 'Pile ou face sert à décider qui donne le coup d’envoi d’un match, à départager une égalité, à trancher rapidement par oui ou non, et en classe pour enseigner les probabilités. Lancez 100 pièces à la fois pour voir la loi des grands nombres à l’œuvre : plus vous lancez, plus la répartition se rapproche de 50 %.',
            ],
        ],
        'faqs' => [
            ['q' => 'Ce pile ou face est-il équitable ?', 'a' => 'Oui. Chaque lancer a exactement 50 % de chances de tomber sur face et 50 % sur pile, grâce à l’aléa cryptographiquement sûr de votre navigateur.'],
            ['q' => 'Puis-je lancer plusieurs pièces ?', 'a' => 'Oui. Choisissez 2, 5, 10, 25 ou 100 pièces : elles sont toutes lancées d’un coup, avec le décompte des faces et des piles.'],
            ['q' => 'Pourquoi ai-je obtenu face cinq fois de suite ?', 'a' => 'Les séries font partie du hasard. La probabilité d’obtenir cinq faces d’affilée est d’environ 3 % : cela arrive régulièrement sur de nombreux lancers.'],
            ['q' => 'Est-ce un simulateur de pile ou face ?', 'a' => 'Oui, c’est un simulateur de pile ou face gratuit : il reproduit un vrai lancer avec une probabilité réelle de 50/50, une animation 3D réaliste et la possibilité de lancer jusqu’à 100 pièces à la fois.'],
            ['q' => 'Est-ce comme demander à un assistant vocal de jouer à pile ou face ?', 'a' => 'Oui : vous obtenez le même résultat équitable de 50/50 qu’en le demandant à un assistant vocal, mais ici vous voyez une animation 3D réaliste, pouvez lancer jusqu’à 100 pièces à la fois, et le jeu compte faces, piles et votre série.'],
        ],
    ],

    'spin-the-wheel' => [
        'name' => 'Roue aléatoire',
        'title' => 'Roue aléatoire : tirage au sort de noms et de choix',
        'description' => 'Faites tourner une roue pour tirer au sort un nom, un gagnant ou un choix. Jusqu’à 100 entrées, animation fluide et retrait des gagnants.',
        'h1' => 'Roue aléatoire',
        'tagline' => 'Ajoutez des noms ou des choix, faites tourner et laissez la roue désigner un gagnant.',
        'keywords' => ['roue aléatoire', 'roue de la fortune en ligne', 'tirage au sort de noms', 'roue des prénoms', 'choix aléatoire'],
        'intro' => 'La roue aléatoire est un outil de tirage au sort : vous ajoutez des noms ou des choix, vous la faites tourner et elle s’arrête sur l’un d’eux au hasard. Impossible de décider quoi manger, qui passe ensuite ou qui gagne le concours ? Saisissez vos options dans la liste, une par ligne, et faites tourner la roue. Elle fait plusieurs tours puis ralentit jusqu’à s’arrêter sur une entrée au hasard, avant d’annoncer le gagnant. Vous pouvez retirer automatiquement chaque gagnant pour tirer des noms un par un sans répétition.',
        'steps' => [
            'Saisissez ou collez vos entrées, une par ligne (jusqu’à 100).',
            'Appuyez sur Tourner, cliquez au centre de la roue ou appuyez sur S.',
            'Regardez la roue ralentir et s’arrêter sur le gagnant.',
            'Cochez éventuellement « Retirer le gagnant après chaque tour » pour tirer sans répétition.',
        ],
        'features' => [
            'Jusqu’à 100 entrées, chacune avec sa part colorée',
            'Rotation fluide qui ralentit jusqu’à l’arrêt, avec annonce du gagnant',
            'Retrait des gagnants automatique ou en un clic',
            'Mélange de l’ordre des entrées',
            'Chaque entrée a exactement la même chance de gagner',
        ],
        'content' => [
            [
                'heading' => 'Comment la roue choisit le gagnant',
                'body' => 'Quand vous appuyez sur Tourner, le gagnant est d’abord choisi avec le générateur aléatoire sécurisé de votre navigateur : chaque entrée a la même chance, quelle que soit la longueur de son nom. La roue calcule ensuite exactement de combien tourner pour que la part choisie s’arrête sous le pointeur, en ajoutant plusieurs tours complets et un point d’arrêt aléatoire dans la part, pour que chaque tour soit différent.',
            ],
            [
                'heading' => 'Idées d’utilisation d’une roue',
                'body' => 'Les enseignants s’en servent pour interroger les élèves équitablement, les streamers et les boutiques pour leurs concours, et les amis pour choisir un restaurant, un film ou les corvées. Activez « Retirer le gagnant après chaque tour » pour établir un ordre de passage, former des équipes ou désigner plusieurs gagnants sans que personne ne gagne deux fois.',
            ],
        ],
        'faqs' => [
            ['q' => 'La roue est-elle vraiment aléatoire ?', 'a' => 'Oui. Le gagnant est tiré avec un aléa cryptographiquement sûr avant l’arrêt de la roue : chaque entrée a la même chance.'],
            ['q' => 'Combien de noms puis-je ajouter ?', 'a' => 'Jusqu’à 100 entrées. Mettez chacune sur sa propre ligne.'],
            ['q' => 'Puis-je retirer un nom une fois qu’il a gagné ?', 'a' => 'Oui. Cliquez sur le bouton Retirer après un tour, ou cochez « Retirer le gagnant après chaque tour » pour le faire automatiquement.'],
            ['q' => 'Mes entrées sont-elles enregistrées ou partagées ?', 'a' => 'Non. Votre liste reste dans votre navigateur et n’est jamais envoyée.'],
        ],
    ],

    'random-number-generator' => [
        'name' => 'Générateur de nombres aléatoires',
        'title' => 'Générateur de nombres aléatoires dans toute plage',
        'description' => 'Générez des nombres aléatoires dans n’importe quelle plage, un ou des centaines, avec ou sans doublons. Idéal pour tombolas et loto.',
        'h1' => 'Générateur de nombres aléatoires',
        'tagline' => 'Tirez des nombres au hasard dans n’importe quelle plage, sans doublons si besoin.',
        'keywords' => ['générateur de nombres aléatoires', 'nombre aléatoire', 'tirage de nombres', 'tirer un nombre au hasard', 'générateur de numéros de loto'],
        'intro' => 'Un générateur de nombres aléatoires est un outil qui tire des nombres au hasard dans la plage de votre choix. Générez un nombre aléatoire entre deux valeurs, ou toute une liste. Choisissez le minimum, le maximum et le nombre de tirages, puis décidez si les doublons sont autorisés et si la liste doit être triée. Idéal pour les tombolas, le loto, les activités en classe, l’échantillonnage et les jeux.',
        'steps' => [
            'Saisissez le minimum et le maximum (les nombres négatifs fonctionnent aussi).',
            'Choisissez combien de nombres vous voulez, jusqu’à 1 000.',
            'Cochez « Sans doublons » et « Trier par ordre croissant » si nécessaire.',
            'Appuyez sur Générer ou utilisez un préréglage comme 1-100 ou 6 sur 49.',
        ],
        'features' => [
            'N’importe quelle plage de nombres entiers, négatifs compris',
            'Jusqu’à 1 000 nombres à la fois',
            'Mode sans doublons pour tombolas et loteries',
            'Tri facultatif et copie des résultats en un clic',
            'Aléa sécurisé et sans biais de votre navigateur',
        ],
        'content' => [
            [
                'heading' => 'Les nombres sont-ils vraiment aléatoires ?',
                'body' => 'Les nombres proviennent de la Web Crypto API, un générateur de nombres aléatoires cryptographiquement sûr intégré à tous les navigateurs modernes. Le générateur utilise aussi l’échantillonnage par rejet, une technique qui supprime le léger biais de nombreux outils simples : chaque nombre de la plage a exactement la même probabilité.',
            ],
            [
                'heading' => 'Tirer des nombres sans doublons',
                'body' => 'Activez « Sans doublons » quand chaque nombre ne doit sortir qu’une fois, par exemple pour tirer des billets de tombola ou des numéros de loto. L’outil vérifie que la plage est assez grande : impossible de tirer 10 nombres différents entre 1 et 5. Avec doublons autorisés, chaque nombre est tiré indépendamment, comme si vous lanciez un dé plusieurs fois.',
            ],
        ],
        'faqs' => [
            ['q' => 'Puis-je générer un nombre aléatoire entre 1 et 100 ?', 'a' => 'Oui. Réglez le minimum sur 1 et le maximum sur 100, ou cliquez sur le préréglage 1-100, puis appuyez sur Générer.'],
            ['q' => 'Puis-je générer des numéros de loto ?', 'a' => 'Oui. Utilisez le préréglage « Loto 6 sur 49 », ou choisissez votre propre plage et quantité avec « Sans doublons » coché.'],
            ['q' => 'Combien de nombres puis-je générer à la fois ?', 'a' => 'Jusqu’à 1 000 nombres par clic. Vous pouvez tous les copier avec un seul bouton.'],
            ['q' => 'Puis-je utiliser des nombres négatifs ?', 'a' => 'Oui. Tous les nombres entiers fonctionnent, par exemple une plage de -50 à 50.'],
        ],
    ],

    'stopwatch' => [
        'name' => 'Chronomètre',
        'title' => 'Chronomètre en ligne gratuit avec temps au tour',
        'description' => 'Chronomètre en ligne gratuit précis au centième de seconde, avec temps au tour, temps intermédiaires, meilleur tour et raccourcis clavier.',
        'h1' => 'Chronomètre en ligne',
        'tagline' => 'Précis au centième de seconde, avec tours, temps intermédiaires et raccourcis clavier.',
        'keywords' => ['chronomètre', 'chronomètre en ligne', 'chronomètre avec tours', 'chrono', 'chronomètre tours'],
        'intro' => 'Un chronomètre mesure le temps écoulé entre son démarrage et son arrêt, et peut enregistrer des temps au tour. Chronométrez une course, une présentation, une recette ou une séance de sport avec ce chronomètre en ligne gratuit. Il compte au centième de seconde, enregistre les temps au tour et intermédiaires, et met en évidence vos tours le plus rapide et le plus lent. Comme il mesure le temps réellement écoulé, il reste précis même si vous changez d’onglet.',
        'steps' => [
            'Appuyez sur Démarrer (ou sur la barre d’espace) pour lancer le chrono.',
            'Appuyez sur Tour (ou L) pour enregistrer un tour sans arrêter le chrono.',
            'Appuyez sur Arrêter pour mettre en pause, puis sur Reprendre pour continuer.',
            'Appuyez sur Réinitialiser (ou R) pour effacer le temps et les tours. Copiez les tours pour les coller où vous voulez.',
        ],
        'features' => [
            'Précision au centième de seconde',
            'Tours illimités avec temps au tour et temps total (intermédiaire)',
            'Tours le plus rapide et le plus lent mis en évidence',
            'Raccourcis clavier : Espace, L et R',
            'Reste exact dans les onglets en arrière-plan',
        ],
        'content' => [
            [
                'heading' => 'Quelle est la précision d’un chronomètre en ligne ?',
                'body' => 'Ce chronomètre lit l’horloge haute résolution de votre appareil à chaque rafraîchissement de l’affichage, au lieu de compter des tics de minuterie : les petits retards ne s’accumulent jamais. Les navigateurs ralentissent les pages en arrière-plan, mais comme le temps écoulé est toujours calculé depuis l’instant de départ, la mesure reste juste à votre retour.',
            ],
            [
                'heading' => 'Temps au tour ou temps intermédiaire',
                'body' => 'Le temps au tour est la durée d’un seul tour, par exemple 1:05 pour le troisième tour de piste. Le temps intermédiaire (ou total) est le temps écoulé depuis le départ, par exemple 3:20 à la fin du troisième tour. Le tableau des tours affiche les deux pour voir d’un coup d’œil votre rythme et votre progression.',
            ],
        ],
        'faqs' => [
            ['q' => 'Le chronomètre continue-t-il dans un autre onglet ?', 'a' => 'Oui. Il mesure le temps réellement écoulé : la mesure est juste même si l’onglet est resté en arrière-plan.'],
            ['q' => 'Comment enregistrer un tour ?', 'a' => 'Appuyez sur Tour pendant que le chronomètre tourne, ou sur la touche L. Chaque tour affiche son propre temps et le temps total.'],
            ['q' => 'Ce chronomètre en ligne est-il vraiment gratuit ?', 'a' => 'Oui, il est entièrement gratuit : sans inscription, sans téléchargement et sans limite de temps. Il fonctionne directement dans le navigateur.'],
            ['q' => 'Puis-je enregistrer mes temps au tour ?', 'a' => 'Appuyez sur Copier les tours pour copier tous les temps au tour et totaux, puis collez-les dans un tableur, une note ou un message.'],
            ['q' => 'Un chrono est-il la même chose qu’un minuteur ?', 'a' => 'Non. Un chronomètre, comme cet outil (aussi appelé chrono), compte en montant depuis zéro pour mesurer la durée d’une action. Un minuteur compte à rebours depuis une durée choisie et sonne une alarme à la fin : c’est à cela que sert le Minuteur.'],
        ],
    ],

    'countdown-timer' => [
        'name' => 'Minuteur',
        'title' => 'Minuteur en ligne : compte à rebours avec alarme',
        'description' => 'Minuteur en ligne gratuit en secondes, minutes ou heures avec préréglages. Une alarme sonne à la fin et l’onglet affiche le temps restant.',
        'h1' => 'Minuteur',
        'tagline' => 'Réglez des minutes ou des heures, ou touchez un préréglage. Une alarme sonne à la fin.',
        'keywords' => ['minuteur', 'minuteur en ligne', 'minuteur avec alarme', 'minuteur 5 minutes', 'compte à rebours'],
        'intro' => 'Un minuteur décompte une durée choisie jusqu’à zéro, puis déclenche une alarme. Réglez un minuteur pour la cuisine, les révisions, le sport, les réunions ou les examens. Saisissez n’importe quelle durée jusqu’à 99 heures ou touchez un préréglage comme 5 ou 25 minutes. Un anneau décompte le temps restant, l’onglet du navigateur l’affiche et une alarme sonne quand le compte à rebours atteint zéro.',
        'steps' => [
            'Saisissez les heures, minutes et secondes, ou touchez un préréglage.',
            'Appuyez sur Démarrer (ou Espace). L’anneau et le titre de l’onglet décomptent.',
            'Mettez en pause, reprenez ou ajoutez une minute à tout moment.',
            'Quand l’alarme sonne, appuyez sur Arrêter l’alarme, puis sur Nouveau minuteur pour recommencer.',
        ],
        'features' => [
            'Toute durée de 1 seconde à 99 heures 59 minutes',
            'Préréglages en un clic de 30 secondes à 1 heure',
            'Alarme sonore, avec option pour la couper',
            'Temps restant dans le titre de l’onglet',
            'Pause, reprise et +1 minute, avec raccourcis clavier',
        ],
        'content' => [
            [
                'heading' => 'Le minuteur fonctionne-t-il en arrière-plan ?',
                'body' => 'Oui. Le minuteur calcule l’instant exact où il doit se terminer : il reste précis même quand vous changez d’onglet et que le navigateur ralentit la page. Le temps restant s’affiche aussi dans le titre de l’onglet pour le surveiller pendant que vous travaillez ailleurs. Gardez l’onglet ouvert et le son activé pour entendre l’alarme.',
            ],
            [
                'heading' => 'Durées de minuteur populaires',
                'body' => 'Cinq minutes, c’est idéal pour le thé, les courtes pauses et les exercices rapides. Vingt-cinq minutes correspondent à la session de concentration Pomodoro classique, suivie en général de cinq minutes de pause. Les minuteurs de 30 ou 60 minutes conviennent aux examens, aux réunions et à la pâtisserie. Utilisez les préréglages ou saisissez n’importe quelle autre durée.',
            ],
        ],
        'faqs' => [
            ['q' => 'Le minuteur fait-il du bruit ?', 'a' => 'Oui. Une alarme sonne à la fin, pendant 30 secondes au plus ou jusqu’à ce que vous appuyiez sur Arrêter l’alarme. Vous pouvez couper le son.'],
            ['q' => 'Pourquoi n’ai-je pas entendu l’alarme ?', 'a' => 'Vérifiez que le volume est monté et que l’onglet est toujours ouvert. Les navigateurs n’autorisent le son qu’après un clic sur la page, ce qui se produit quand vous appuyez sur Démarrer.'],
            ['q' => 'Quelle est la durée maximale ?', 'a' => 'Jusqu’à 99 heures, 59 minutes et 59 secondes.'],
            ['q' => 'Puis-je mettre le minuteur en pause ?', 'a' => 'Oui. Appuyez sur Pause (ou Espace), puis sur Reprendre pour continuer. Vous pouvez aussi ajouter une minute pendant qu’il tourne.'],
        ],
    ],

    'sleep-calculator' => [
        'name' => 'Calculateur de sommeil',
        'title' => 'Calcul du sommeil : meilleure heure de coucher et de réveil',
        'description' => 'Trouvez la meilleure heure de coucher ou de réveil selon les cycles de 90 minutes, ou comptez vos heures de sommeil. Réveil en forme.',
        'h1' => 'Calculateur de sommeil',
        'tagline' => 'Trouvez la meilleure heure de coucher ou de réveil, et comptez vos heures de sommeil.',
        'keywords' => ['calculateur de sommeil', 'compteur de sommeil', 'heure de coucher', 'calcul cycles de sommeil', 'à quelle heure me coucher', 'heures de sommeil'],
        'intro' => 'Un calculateur de sommeil suggère l’heure du coucher ou du réveil pour que vous vous réveilliez à la fin d’un cycle, quand le sommeil est le plus léger. Se réveiller au milieu d’un cycle de sommeil explique pourquoi un réveil peut vous laisser groggy même après une nuit complète. Ce calculateur suit le rythme naturel des cycles d’environ 90 minutes : indiquez l’heure à laquelle vous devez vous lever et il suggère quand vous coucher, ou indiquez l’heure du coucher et il suggère les meilleures heures de réveil. Il peut aussi compter vos heures de sommeil et les comparer aux 7-9 heures recommandées.',
        'steps' => [
            'Choisissez quoi calculer : une heure de coucher, une heure de réveil, « Dormir maintenant » ou les heures dormies.',
            'Saisissez l’heure. Ajustez le temps que vous mettez d’habitude à vous endormir (15 minutes par défaut).',
            'Choisissez l’une des heures suggérées. « Recommandé » donne 7,5 heures et « Meilleur repos » 9 heures de sommeil.',
            'Touchez une heure pour voir le graphique de vos cycles de sommeil cette nuit-là.',
        ],
        'features' => [
            'Heures de coucher selon une heure de réveil, et heures de réveil selon une heure de coucher',
            'Mode « Dormir maintenant » basé sur l’heure actuelle',
            'Compteur d’heures dormies avec la référence de 7-9 heures',
            'Temps d’endormissement réglable et horloge 12 ou 24 heures',
            'Graphique animé du sommeil léger, profond et paradoxal au fil de la nuit',
        ],
        'content' => [
            [
                'heading' => 'Qu’est-ce qu’un cycle de sommeil ?',
                'body' => 'Pendant la nuit, vous passez par le sommeil léger, le sommeil profond et le sommeil paradoxal (celui des rêves) en cycles d’environ 90 minutes, généralement quatre à six fois par nuit. Les premiers cycles contiennent le plus de sommeil profond, les derniers davantage de sommeil paradoxal. Se réveiller à la fin d’un cycle, quand le sommeil est le plus léger, est en général plus facile que d’être tiré du sommeil profond.',
            ],
            [
                'heading' => 'De combien de sommeil avez-vous besoin ?',
                'body' => 'Les organismes de santé du sommeil recommandent 7 à 9 heures par nuit pour les adultes, 8 à 10 heures pour les adolescents et 9 à 12 heures pour les enfants d’âge scolaire. Cinq cycles complets (7,5 heures) ou six cycles (9 heures) respectent ces recommandations pour les adultes. Chacun est un peu différent et la durée des cycles varie d’une personne à l’autre : considérez les heures proposées comme un guide utile plutôt qu’une règle stricte.',
            ],
        ],
        'faqs' => [
            ['q' => 'À quelle heure me coucher pour me lever à 7 h ?', 'a' => 'Pour 7 h 00, essayez de vous endormir vers 23 h 30 pour cinq cycles (7,5 heures) ou vers 22 h 00 pour six cycles (9 heures). Avec 15 minutes d’endormissement, couchez-vous donc à 23 h 15 ou à 21 h 45.'],
            ['q' => 'Combien de temps dure un cycle de sommeil ?', 'a' => 'Un cycle de sommeil dure en moyenne environ 90 minutes, mais il peut varier d’environ 80 à 120 minutes selon les personnes et au fil de la nuit.'],
            ['q' => 'Pourquoi suis-je fatigué après 8 heures de sommeil ?', 'a' => 'Si votre réveil sonne pendant le sommeil profond, vous pouvez vous sentir groggy même après une longue nuit. Régler le réveil sur la fin d’un cycle et garder des horaires réguliers aide souvent.'],
            ['q' => 'Comment le compteur calcule-t-il les heures dormies ?', 'a' => 'Choisissez « Heures dormies », puis indiquez l’heure du coucher et celle du réveil. Il gère le passage de minuit, déduit le temps d’endormissement et compare le résultat aux 7-9 heures dont les adultes ont besoin.'],
            ['q' => 'Ce calculateur est-il un avis médical ?', 'a' => 'Non. C’est un guide général fondé sur des cycles de sommeil moyens. Si vous avez régulièrement du mal à dormir, parlez-en à un médecin.'],
        ],
        'table' => [
            'caption' => 'Heures de coucher selon l’heure de réveil (15 minutes d’endormissement)',
            'headers' => ['Réveil à', '6 cycles (9 h)', '5 cycles (7,5 h)', '4 cycles (6 h)'],
            'rows' => [
                ['06:00', '20:45', '22:15', '23:45'],
                ['06:30', '21:15', '22:45', '00:15'],
                ['07:00', '21:45', '23:15', '00:45'],
                ['07:30', '22:15', '23:45', '01:15'],
                ['08:00', '22:45', '00:15', '01:45'],
            ],
        ],
    ],

    'avif-to-jpg' => [
        'name' => 'AVIF en JPG',
        'title' => 'Convertir AVIF en JPG gratuit, privé et par lots',
        'description' => 'Convertissez des AVIF en JPG en ligne gratuitement. Jusqu’à 30 images à la fois, qualité réglable et ZIP. Vos images ne quittent pas votre appareil.',
        'h1' => 'Convertisseur AVIF en JPG',
        'tagline' => 'Transformez vos images AVIF en JPG lisibles partout.',
        'keywords' => ['avif en jpg', 'convertir avif en jpg', 'convertisseur avif jpg', 'avif en jpeg', 'ouvrir un fichier avif'],
        'intro' => 'L’AVIF est un format d’image moderne basé sur le codec vidéo AV1 qui produit des fichiers très légers, mais beaucoup d’applications, d’éditeurs et de formulaires ne savent pas encore l’ouvrir. Ce convertisseur AVIF en JPG transforme vos images AVIF en JPG, le format le plus compatible. Déposez une image ou un lot entier, choisissez la qualité et téléchargez les résultats un par un ou dans un ZIP.',
        'steps' => [
            'Déposez vos images AVIF dans le cadre ou cliquez pour les choisir (jusqu’à 30 à la fois).',
            'Réglez la qualité du JPG si besoin ; 85 % garde des photos nettes avec un poids réduit.',
            'Cliquez sur Télécharger à côté d’une image, ou sur Tout télécharger (ZIP) pour le lot.',
        ],
        'features' => [
            'Convertit l’AVIF en JPG dans votre navigateur',
            'Jusqu’à 30 images par lot avec téléchargement ZIP',
            'Qualité JPG réglable',
            '100 % privé : rien n’est envoyé',
        ],
        'content' => [
            ['heading' => 'Pourquoi convertir l’AVIF en JPG ?', 'body' => 'Un fichier AVIF pèse souvent 30 à 50 % de moins qu’un JPG de même qualité visuelle, c’est pourquoi de nombreux sites servent désormais leurs images en AVIF. Une fois enregistrées, ces images peuvent être refusées par les anciens logiciels photo, les documents bureautiques, les imprimantes et certains réseaux sociaux. Le JPG fonctionne presque partout : en convertissant, vous obtenez un fichier utilisable n’importe où.'],
            ['heading' => 'Que devient la transparence ?', 'body' => 'Le JPG ne gère pas la transparence. Si votre image AVIF contient des zones transparentes, elles deviennent blanches dans le JPG. Pour conserver la transparence, utilisez plutôt le convertisseur AVIF en PNG.'],
        ],
        'faqs' => [
            ['q' => 'Comment convertir un AVIF en JPG ?', 'a' => 'Déposez le fichier AVIF dans le cadre ci-dessus. Il est converti en JPG immédiatement et vous le téléchargez en un clic.'],
            ['q' => 'Pourquoi je n’arrive pas à ouvrir les fichiers AVIF ?', 'a' => 'L’AVIF est un format récent. Les navigateurs actuels l’ouvrent, mais beaucoup d’anciennes applications et de logiciels photo ne le gèrent pas encore : le convertir en JPG est la solution la plus simple.'],
            ['q' => 'Le JPG sera-t-il plus lourd que l’AVIF ?', 'a' => 'En général, oui. L’AVIF compresse les images plus efficacement que le JPG, donc la même image prend plus de place en JPG.'],
            ['q' => 'Mes images sont-elles envoyées sur un serveur ?', 'a' => 'Non. Votre navigateur décode l’AVIF et enregistre le JPG sur votre appareil : vos images ne quittent jamais votre ordinateur ou votre téléphone.'],
        ],
    ],

    'avif-to-png' => [
        'name' => 'AVIF en PNG',
        'title' => 'Convertir AVIF en PNG gratuit, avec transparence',
        'description' => 'Convertissez des AVIF en PNG en ligne gratuitement. La transparence est conservée, jusqu’à 30 images par lot et téléchargement ZIP. Rien n’est envoyé.',
        'h1' => 'Convertisseur AVIF en PNG',
        'tagline' => 'Convertissez vos AVIF en PNG en gardant la transparence.',
        'keywords' => ['avif en png', 'convertir avif en png', 'convertisseur avif png', 'convertisseur avif', 'avif en png transparent'],
        'intro' => 'Convertir un AVIF en PNG transforme une image AVIF moderne et très compressée en PNG sans perte, que presque toutes les applications savent ouvrir. Les fonds transparents restent transparents, ce qui fait du PNG le bon choix pour les logos, icônes et graphiques. Déposez une image ou un lot et téléchargez-les un par un ou dans un ZIP.',
        'steps' => [
            'Déposez vos images AVIF dans le cadre ou cliquez pour les choisir (jusqu’à 30 à la fois).',
            'Chaque image est convertie en PNG immédiatement, dans votre navigateur.',
            'Cliquez sur Télécharger à côté d’une image, ou sur Tout télécharger (ZIP) pour le lot.',
        ],
        'features' => [
            'Convertit l’AVIF en PNG sans perte',
            'Conserve les fonds transparents',
            'Jusqu’à 30 images par lot avec téléchargement ZIP',
            '100 % privé : rien n’est envoyé',
        ],
        'content' => [
            ['heading' => 'Quand choisir le PNG plutôt que le JPG ?', 'body' => 'Choisissez le PNG pour les logos, icônes, captures d’écran et toute image avec des zones transparentes ou des contours nets, car le PNG est sans perte et gère la transparence. Pour des photos classiques, le JPG donne des fichiers bien plus légers : AVIF en JPG est alors souvent le meilleur choix.'],
            ['heading' => 'La conversion AVIF en PNG fait-elle perdre en qualité ?', 'body' => 'La conversion elle-même n’ajoute aucune perte, car le PNG enregistre chaque pixel à l’identique. Si l’AVIF d’origine a été compressé avec perte, cette perte antérieure reste, mais aucune nouvelle n’est ajoutée.'],
        ],
        'faqs' => [
            ['q' => 'Comment convertir un AVIF en PNG ?', 'a' => 'Déposez le fichier AVIF dans le cadre ci-dessus. Il est converti en PNG immédiatement et vous le téléchargez en un clic.'],
            ['q' => 'La transparence est-elle conservée ?', 'a' => 'Oui. Le PNG gère la transparence : les zones transparentes de l’AVIF le restent dans le PNG.'],
            ['q' => 'Pourquoi le PNG est-il beaucoup plus lourd ?', 'a' => 'L’AVIF utilise une compression très efficace alors que le PNG est sans perte : la même image peut peser plusieurs fois plus en PNG.'],
            ['q' => 'Mes images sont-elles envoyées sur un serveur ?', 'a' => 'Non. La conversion se fait dans votre navigateur et vos images ne quittent jamais votre appareil.'],
        ],
    ],

    'avif-to-webp' => [
        'name' => 'AVIF en WebP',
        'title' => 'Convertir AVIF en WebP gratuit en ligne, par lots',
        'description' => 'Convertissez des AVIF en WebP en ligne gratuitement. Fichiers légers et transparence conservée, jusqu’à 30 images par lot et ZIP. Rien n’est envoyé.',
        'h1' => 'Convertisseur AVIF en WebP',
        'tagline' => 'Convertissez l’AVIF en WebP et gardez des fichiers légers.',
        'keywords' => ['avif en webp', 'convertir avif en webp', 'convertisseur avif webp', 'avif webp', 'convertisseur avif en ligne'],
        'intro' => 'Convertir un AVIF en WebP vous donne une image légère et adaptée au web, acceptée par davantage d’applications et de CMS que l’AVIF. Le WebP garde la transparence et compresse bien : vos fichiers restent bien plus légers qu’en PNG ou en JPG. Déposez une image ou un lot, choisissez la qualité et téléchargez les résultats.',
        'steps' => [
            'Déposez vos images AVIF dans le cadre ou cliquez pour les choisir (jusqu’à 30 à la fois).',
            'Réglez la qualité du WebP si besoin ; 85 % offre un bon équilibre entre poids et netteté.',
            'Cliquez sur Télécharger à côté d’une image, ou sur Tout télécharger (ZIP) pour le lot.',
        ],
        'features' => [
            'Convertit l’AVIF en WebP dans votre navigateur',
            'Conserve les fonds transparents',
            'Qualité réglable et téléchargement du lot en ZIP',
            '100 % privé : rien n’est envoyé',
        ],
        'content' => [
            ['heading' => 'AVIF ou WebP : lequel choisir ?', 'body' => 'Ce sont deux formats modernes qui gèrent la transparence. L’AVIF donne souvent des fichiers plus légers, mais le WebP existe depuis plus longtemps et il est accepté par plus d’applications, d’extensions et de formulaires. Passer au WebP est un bon compromis quand un site ou un outil refuse l’AVIF mais que vous voulez des images légères.'],
            ['heading' => 'Le WebP sera-t-il identique ?', 'body' => 'À partir de 85 % de qualité, la différence est très difficile à voir. Chaque enregistrement avec perte peut retirer un peu de détail : pour archiver ou retoucher ensuite, AVIF en PNG conserve tous les pixels.'],
        ],
        'faqs' => [
            ['q' => 'Comment convertir un AVIF en WebP ?', 'a' => 'Déposez le fichier AVIF dans le cadre ci-dessus, choisissez la qualité et téléchargez le WebP en un clic.'],
            ['q' => 'La transparence est-elle conservée ?', 'a' => 'Oui. Le WebP gère la transparence : les zones transparentes restent transparentes.'],
            ['q' => 'Quels navigateurs peuvent le faire ?', 'a' => 'Les versions actuelles de Chrome, Edge, Firefox et Safari savent lire l’AVIF et enregistrer du WebP : le convertisseur fonctionne donc dans tous ces navigateurs.'],
            ['q' => 'Mes images sont-elles envoyées sur un serveur ?', 'a' => 'Non. Tout se passe dans votre navigateur et vos images ne quittent jamais votre appareil.'],
        ],
    ],

    'readability-checker' => [
        'name' => 'Test de lisibilité',
        'title' => 'Test de lisibilité gratuit : score Flesch et niveau',
        'description' => 'Test de lisibilité gratuit : obtenez le score Flesch, le niveau scolaire, les indices Gunning Fog et SMOG, et repérez les phrases trop longues.',
        'h1' => 'Test de lisibilité',
        'tagline' => 'Voyez si votre texte est facile à lire, et quoi améliorer.',
        'keywords' => ['test de lisibilité', 'lisibilité d’un texte', 'score de lisibilité', 'indice flesch', 'niveau de lecture', 'outil de lisibilité'],
        'intro' => 'Un test de lisibilité mesure la facilité de lecture d’un texte grâce à des formules basées sur la longueur des phrases et des mots. Collez un article, un devoir, un e-mail ou un brouillon rédigé par une IA pour obtenir le score de facilité de lecture Flesch, le niveau scolaire selon cinq formules et la liste des phrases trop longues à raccourcir. Le texte est analysé dans votre navigateur et n’est jamais envoyé.',
        'steps' => [
            'Collez ou tapez votre texte dans le cadre.',
            'Lisez le score Flesch et le niveau scolaire donné par chaque formule.',
            'Raccourcissez les phrases longues listées sous les résultats, puis vérifiez à nouveau.',
        ],
        'features' => [
            'Score Flesch et niveau Flesch-Kincaid',
            'Gunning Fog, SMOG, Coleman-Liau et indice ARI',
            'Repère les phrases de plus de 25 mots',
            'Résultats immédiats ; rien n’est envoyé',
        ],
        'content' => [
            ['heading' => 'Qu’est-ce qu’un bon score de lisibilité ?', 'body' => 'Pour la plupart des sites, blogs et e-mails, visez un score Flesch d’au moins 60, soit un langage simple que presque tous les adultes lisent facilement, et un niveau scolaire de 8 ou moins. Les textes techniques et universitaires obtiennent souvent 30 à 50, ce qui convient à des experts mais reste difficile pour les autres.'],
            ['heading' => 'Comment rendre mon texte plus facile à lire ?', 'body' => 'Coupez les phrases longues en deux, préférez les mots courts et courants, utilisez la voix active et découpez les gros paragraphes. Ces changements font monter directement le score Flesch, car il se calcule à partir du nombre de mots par phrase et de syllabes par mot.'],
        ],
        'faqs' => [
            ['q' => 'Qu’est-ce que le score de facilité de lecture Flesch ?', 'a' => 'C’est un score de 0 à 100 basé sur la longueur moyenne des phrases et le nombre de syllabes par mot. Plus il est élevé, plus le texte est facile : 60-70 correspond à un langage simple et plus de 90 à un texte très facile.'],
            ['q' => 'Que signifie le niveau scolaire ?', 'a' => 'C’est la classe américaine dont un lecteur a besoin pour comprendre le texte. Le niveau 8 correspond à un élève typique de 13 ou 14 ans.'],
            ['q' => 'Puis-je tester un texte écrit par une IA ?', 'a' => 'Oui. Les brouillons d’IA contiennent souvent des phrases et des mots longs ; l’outil indique quelles phrases raccourcir pour un texte plus naturel.'],
            ['q' => 'Est-ce que ça fonctionne en français ?', 'a' => 'Les formules ont été conçues pour l’anglais : en français, les résultats ne sont qu’une indication approximative.'],
        ],
        'table' => [
            'caption' => 'Scores de facilité de lecture Flesch',
            'headers' => ['Score', 'Niveau', 'Lecteur type'],
            'rows' => [
                ['90-100', 'Très facile', '11 ans'],
                ['60-70', 'Langage simple', '13-15 ans'],
                ['30-50', 'Difficile', 'Études supérieures'],
                ['0-30', 'Très difficile', 'Diplômé universitaire'],
            ],
        ],
    ],

    'ai-content-detector' => [
        'name' => 'Détecteur de contenu IA',
        'title' => 'Détecteur de contenu IA gratuit : vérifiez un texte',
        'description' => 'Détecteur d’IA gratuit : vérifiez si un texte semble généré par une IA, avec un score, les expressions qui le trahissent et quatre signaux d’écriture.',
        'h1' => 'Détecteur de contenu IA',
        'tagline' => 'Voyez à quel point un texte ressemble à de l’IA, et pourquoi.',
        'keywords' => ['détecteur ia', 'détecteur de contenu ia', 'détecteur de texte ia', 'détecteur chatgpt', 'détecter un texte ia', 'détecteur ia gratuit'],
        'intro' => 'Un détecteur de contenu IA estime si un texte a été écrit par un chatbot comme ChatGPT. Celui-ci analyse quatre signaux qui distinguent l’écriture typique d’une IA de celle d’une personne : la régularité des phrases, les expressions typiques de l’IA, les contractions et la variété du vocabulaire. Il donne un score et montre précisément ce qui l’a fait monter. Il analyse les textes en anglais dans votre navigateur, sans rien envoyer.',
        'steps' => [
            'Collez au moins 80 mots d’un texte en anglais dans le cadre.',
            'Cliquez sur Vérifier le texte pour obtenir le score et les quatre signaux.',
            'Repérez les expressions typiques de l’IA trouvées ; les reformuler rend le texte plus humain.',
        ],
        'features' => [
            'Score de ressemblance avec l’IA de 0 à 100 %',
            'Affiche les expressions typiques de l’IA trouvées',
            'Explique chaque signal simplement',
            'Gratuit, illimité et privé : rien n’est envoyé',
        ],
        'content' => [
            ['heading' => 'Comment fonctionne la détection d’IA ?', 'body' => 'Les modèles d’IA écrivent souvent des phrases très régulières, répètent les mêmes formules soignées (« moreover », « it is important to note », « delve ») et évitent les contractions. Les humains mélangent plutôt phrases courtes et longues et écrivent de façon plus naturelle. Le détecteur mesure ces tendances et les combine en un seul score.'],
            ['heading' => 'Les détecteurs d’IA sont-ils fiables ?', 'body' => 'Aucun détecteur d’IA n’est totalement fiable. Un texte humain très formel peut obtenir un score élevé, et un texte d’IA retravaillé ou rédigé sur un ton familier peut obtenir un score faible. Voyez le score comme un indice pour regarder de plus près, jamais comme une preuve, et ne l’utilisez jamais seul pour accuser un élève ou un rédacteur de tricher.'],
        ],
        'faqs' => [
            ['q' => 'Est-ce qu’il détecte ChatGPT ?', 'a' => 'Il repère les tournures que ChatGPT et les modèles similaires produisent souvent. Un texte d’IA retravaillé ou bien guidé peut passer inaperçu.'],
            ['q' => 'De combien de texte ai-je besoin ?', 'a' => 'Au moins 80 mots. Avec 300 mots ou plus, le score est plus pertinent.'],
            ['q' => 'Un texte humain peut-il être vu comme de l’IA ?', 'a' => 'Oui. Un texte très formel et régulier avec des mots comme « furthermore » peut obtenir un score élevé même s’il a été écrit par une personne. C’est pourquoi le score n’est qu’une indication.'],
            ['q' => 'Mon texte est-il conservé ?', 'a' => 'Non. L’analyse se fait dans votre navigateur et votre texte n’est jamais envoyé nulle part.'],
        ],
    ],

    'remove-background' => [
        'name' => 'Supprimer l’arrière-plan',
        'title' => 'Supprimer l’arrière-plan d’une image, gratuit',
        'description' => 'Supprimez gratuitement l’arrière-plan de n’importe quelle image grâce à l’IA. PNG transparent ou fond coloré en quelques secondes. Rien n’est envoyé.',
        'h1' => 'Supprimer l’arrière-plan d’une image',
        'tagline' => 'Détourez personnes, produits et animaux en un clic.',
        'keywords' => [
            'supprimer arrière-plan',
            'enlever le fond d’une image',
            'détourer une photo',
            'fond transparent',
            'remove bg',
            'png transparent',
        ],
        'intro' => 'Un outil de suppression d’arrière-plan détoure le sujet principal d’une photo et rend transparent tout ce qui se trouve derrière. Celui-ci utilise un modèle d’IA qui fonctionne dans votre navigateur : déposez la photo d’une personne, d’un produit, d’un animal ou d’un logo et téléchargez un PNG transparent, ou placez-le sur du blanc ou la couleur de votre choix. Votre image n’est jamais envoyée ; seul le modèle d’IA est téléchargé une fois.',
        'steps' => [
            'Déposez une image JPG, PNG, WebP ou AVIF dans le cadre.',
            'Patientez quelques secondes pendant que l’IA supprime l’arrière-plan (la première fois, le modèle est aussi téléchargé).',
            'Choisissez un fond transparent, blanc ou coloré, puis cliquez sur Télécharger le PNG.',
        ],
        'features' => [
            'Suppression d’arrière-plan par IA dans votre navigateur',
            'PNG transparent, fond blanc ou de n’importe quelle couleur',
            'Mode rapide pour tous les appareils, mode haute qualité avec WebGPU',
            'Gratuit, sans inscription, sans filigrane, rien n’est envoyé',
        ],
        'content' => [
            [
                'heading' => 'Rapide ou Haute qualité : lequel choisir ?',
                'body' => 'Le mode rapide utilise un petit modèle de 4,4 Mo qui fonctionne sur n’importe quel téléphone ou ordinateur et détoure bien les sujets nets comme les produits, les personnes et les logos. Le mode haute qualité télécharge une seule fois un modèle de 109 Mo et donne des contours plus propres sur les cheveux, les poils et les petits détails. Il nécessite un navigateur compatible WebGPU, comme une version récente de Chrome ou d’Edge.',
            ],
            [
                'heading' => 'Comment obtenir le meilleur détourage ?',
                'body' => 'Utilisez une photo où le sujet est net et se distingue du fond par sa couleur ou sa luminosité. Les fonds chargés, les photos floues et les sujets qui se confondent avec le décor sont plus difficiles pour tout modèle d’IA. Si un contour semble irrégulier en mode rapide, essayez le mode haute qualité.',
            ],
        ],
        'faqs' => [
            [
                'q' => 'L’outil est-il vraiment gratuit ?',
                'a' => 'Oui. Sans inscription, sans limite quotidienne et sans filigrane, et vous téléchargez le résultat en taille réelle.',
            ],
            [
                'q' => 'Mes photos sont-elles envoyées sur un serveur ?',
                'a' => 'Non. Le modèle d’IA tourne dans votre navigateur, vos photos restent donc sur votre appareil. Seul le fichier du modèle est téléchargé, puis conservé pour la prochaine fois.',
            ],
            [
                'q' => 'Quels formats d’image puis-je utiliser ?',
                'a' => 'JPG, PNG, WebP et AVIF, jusqu’à 50 Mo. Le résultat est un PNG à fond transparent ou de la couleur de votre choix.',
            ],
            [
                'q' => 'Pourquoi la première fois est-elle plus lente ?',
                'a' => 'La première fois, votre navigateur télécharge le modèle d’IA (4,4 Mo en mode rapide, 109 Mo en haute qualité). Ensuite, il est enregistré et démarre bien plus vite.',
            ],
        ],
    ],

    'broken-link-checker' => [
        'name' => 'Vérificateur de liens cassés',
        'title' => 'Vérificateur de liens cassés gratuit : erreurs 404',
        'description' => 'Vérificateur de liens cassés gratuit : trouvez les erreurs 404, liens morts, images cassées et redirections d’une page web, puis exportez la liste en CSV.',
        'h1' => 'Vérificateur de liens cassés',
        'tagline' => 'Trouvez les liens morts, erreurs 404 et redirections d’une page.',
        'keywords' => [
            'vérificateur de liens cassés',
            'liens cassés',
            'vérifier les liens cassés',
            'liens morts',
            'erreur 404',
            'trouver les liens cassés',
        ],
        'intro' => 'Un vérificateur de liens cassés repère les liens d’une page web qui ne fonctionnent plus : erreurs 404 « page introuvable », images supprimées ou noms de domaine expirés. Saisissez l’adresse d’une page et l’outil teste chaque lien et chaque image (jusqu’à 300), indique lesquels sont cassés, lesquels redirigent et lesquels fonctionnent, et vous permet de télécharger les résultats au format CSV.',
        'steps' => [
            'Saisissez l’adresse de la page à vérifier, par exemple example.com/blog.',
            'Cliquez sur Vérifier les liens ; les résultats s’affichent au fur et à mesure des tests.',
            'Corrigez ou supprimez les liens cassés listés dans Problèmes, et mettez à jour ceux qui redirigent.',
        ],
        'features' => [
            'Vérifie tous les liens et images d’une page (jusqu’à 300)',
            'Repère les 404, erreurs serveur, domaines expirés et redirections',
            'Affiche le texte du lien et s’il est interne ou externe',
            'Export CSV gratuit, sans inscription',
        ],
        'content' => [
            [
                'heading' => 'Pourquoi les liens cassés sont-ils importants ?',
                'body' => 'Les liens cassés envoient les visiteurs vers des pages d’erreur, ce qui est frustrant et donne l’image d’un site mal entretenu. Les moteurs de recherche suivent aussi les liens pour découvrir les pages : les liens morts gaspillent leur exploration et peuvent les empêcher de trouver des pages importantes. Les corriger est l’une des améliorations SEO et d’expérience les plus rapides.',
            ],
            [
                'heading' => 'Que signifient les résultats ?',
                'body' => 'OK signifie que le lien fonctionne. Redirection signifie qu’il fonctionne mais passe par une ou plusieurs redirections ; le remplacer par l’adresse finale est plus rapide pour les visiteurs. Cassé signifie que la page a répondu par une erreur comme 404 ou 500, ou que le domaine n’existe plus. Bloqué signifie que le site a refusé la vérification automatique (code 401, 403 ou 429) : ouvrez le lien vous-même pour vérifier.',
            ],
        ],
        'faqs' => [
            [
                'q' => 'Comment trouver les liens cassés de mon site ?',
                'a' => 'Saisissez l’adresse d’une page ci-dessus et cliquez sur Vérifier les liens. Recommencez avec vos pages les plus importantes : accueil, menus et articles les plus lus.',
            ],
            [
                'q' => 'Vérifie-t-il tout le site ?',
                'a' => 'Il vérifie tous les liens et images de la page saisie, jusqu’à 300. Pour vérifier d’autres pages, saisissez leurs adresses une par une.',
            ],
            [
                'q' => 'Pourquoi certains liens sont-ils marqués Bloqués ?',
                'a' => 'Certains sites refusent les requêtes automatiques ou demandent une connexion, et répondent avec le code 401, 403 ou 429. Le lien peut fonctionner dans un navigateur normal : ouvrez-le pour vérifier.',
            ],
            [
                'q' => 'La page ou mes résultats sont-ils conservés ?',
                'a' => 'Non. Notre serveur récupère la page et les liens uniquement pour les vérifier et n’enregistre ni l’adresse ni les résultats.',
            ],
            [
                'q' => 'Un « dead link checker » est-il la même chose que ce vérificateur de liens cassés ?',
                'a' => 'Oui. « Dead link checker », « vérificateur de liens cassés », « erreur 404 » et « détecteur de liens morts » décrivent le même type d’outil : un outil qui teste les liens d’une page et indique lesquels ne fonctionnent plus (liens morts) ou renvoient une erreur comme 404. Cet outil couvre tous ces cas.',
            ],
        ],
        'table' => [
            'caption' => 'Codes de statut HTTP courants',
            'headers' => [
                'Code',
                'Signification',
                'Que faire',
            ],
            'rows' => [
                [
                    '200',
                    'OK',
                    'Rien',
                ],
                [
                    '301 / 308',
                    'Déplacé définitivement',
                    'Mettre le lien à jour vers la nouvelle adresse',
                ],
                [
                    '404',
                    'Page introuvable',
                    'Corriger ou supprimer le lien',
                ],
                [
                    '410',
                    'Supprimée définitivement',
                    'Supprimer le lien',
                ],
                [
                    '500 / 503',
                    'Erreur serveur',
                    'Revérifier plus tard ; prévenir le propriétaire du site',
                ],
            ],
        ],
    ],

    'domain-authority-checker' => [
        'name' => 'Vérificateur d’autorité de domaine',
        'title' => 'Vérificateur d’autorité de domaine gratuit, sans inscription',
        'description' => 'Vérificateur d’autorité de domaine gratuit, sans inscription : score d’autorité, rang mondial et domaines référents de 100 sites à la fois, export CSV.',
        'h1' => 'Vérificateur d’autorité de domaine en masse',
        'tagline' => 'Comparez l’autorité de 100 sites en quelques secondes.',
        'keywords' => [
            'vérificateur d’autorité de domaine',
            'autorité de domaine',
            'domain authority',
            'vérifier le da',
            'autorité d’un site',
            'da checker',
        ],
        'intro' => 'Un vérificateur d’autorité de domaine estime la force d’un site dans les moteurs de recherche selon le nombre de sites qui le citent et leur importance. Collez jusqu’à 100 domaines pour voir le score OpenPageRank de chacun, de 0 à 10, son rang mondial et ses domaines référents, triez-les et téléchargez un CSV. Pratique pour comparer des concurrents, évaluer des partenaires de liens ou choisir des sites pour des articles invités.',
        'steps' => [
            'Collez jusqu’à 100 domaines ou adresses de pages, un par ligne.',
            'Cliquez sur Vérifier l’autorité.',
            'Triez les résultats par score et téléchargez-les en CSV si besoin.',
        ],
        'features' => [
            'Jusqu’à 100 domaines en une seule vérification',
            'Score d’autorité de 0 à 10, rang mondial et domaines référents',
            'Accepte les URL complètes et retire le www automatiquement',
            'Export CSV gratuit, sans inscription',
            'Détails de chaque domaine : registraire, dates d’enregistrement et d’expiration, réseau d’hébergement, fournisseurs DNS et e-mail, certificat HTTPS',
        ],
        'content' => [
            [
                'heading' => 'Est-ce la même chose que le Domain Authority de Moz ?',
                'body' => 'Non. Le Domain Authority (DA) est un score de 0 à 100 appartenant à Moz, et le Domain Rating (DR) appartient à Ahrefs. Cet outil affiche OpenPageRank, un score de 0 à 10 calculé à partir du graphe web public de Common Crawl avec la méthode PageRank. Tous mesurent la même idée, la force des liens d’un site, mais avec des calculs différents : leurs valeurs ne sont donc pas convertibles.',
            ],
            [
                'heading' => 'Qu’est-ce qu’un bon score ?',
                'body' => 'L’échelle est logarithmique : passer de 2 à 3 demande bien moins de liens que passer de 8 à 9. Les nouveaux sites démarrent souvent près de 0, les petits sites établis obtiennent souvent 2 à 4, les marques connues 5 à 7, et seuls les plus grands sites d’internet atteignent 9 ou 10. Comparez un site avec d’autres de sa thématique plutôt qu’avec les géants du web.',
            ],
            [
                'heading' => 'Que montrent les détails du domaine ?',
                'body' => 'Cliquez sur Détails à côté d’un domaine (le panneau s’ouvre seul si vous n’en vérifiez qu’un) pour voir son registraire, sa date d’enregistrement et d’expiration, son âge, l’adresse IP et le réseau qui l’héberge, ses fournisseurs DNS et e-mail, et si son certificat HTTPS est valide et quand il expire. Les données proviennent de l’enregistrement RDAP public du registre, du DNS public et du certificat du site : elles sont gratuites et sans inscription.',
            ],
        ],
        'faqs' => [
            [
                'q' => 'Comment vérifier l’autorité de domaine d’un site ?',
                'a' => 'Collez le domaine dans le cadre et cliquez sur Vérifier l’autorité. Vous pouvez vérifier jusqu’à 100 domaines à la fois.',
            ],
            [
                'q' => 'D’où viennent les scores ?',
                'a' => 'D’OpenPageRank, qui calcule l’autorité à partir du graphe web de Common Crawl, une exploration publique de milliards de pages. Les scores sont mis à jour chaque mois.',
            ],
            [
                'q' => 'Comment augmenter mon score ?',
                'a' => 'Obtenez des liens de sites reconnus dans votre domaine : contenu utile, annuaires de qualité, articles invités et mentions dans la presse. Des liens venant de nombreux sites différents comptent davantage que de nombreux liens d’un même site.',
            ],
            [
                'q' => 'Pourquoi un site est-il marqué Introuvable ?',
                'a' => 'Les sites très récents ou très petits n’ont parfois pas encore assez de liens dans le graphe web pour obtenir un score.',
            ],
            [
                'q' => 'Existe-t-il un vérificateur d’autorité de domaine en masse ?',
                'a' => 'Oui : cet outil vérifie l’autorité de domaine en masse, en lot : collez jusqu’à 100 domaines à la fois et consultez tous les scores ensemble, au lieu de les chercher un par un.',
            ],
        ],
        'table' => [
            'caption' => 'Comparaison des indicateurs d’autorité',
            'headers' => [
                'Indicateur',
                'Créé par',
                'Échelle',
            ],
            'rows' => [
                [
                    'OpenPageRank',
                    'OpenPageRank (données Common Crawl)',
                    '0-10',
                ],
                [
                    'Domain Authority (DA)',
                    'Moz',
                    '0-100',
                ],
                [
                    'Domain Rating (DR)',
                    'Ahrefs',
                    '0-100',
                ],
                [
                    'Authority Score',
                    'Semrush',
                    '0-100',
                ],
            ],
        ],
    ],

    'domain-age-checker' => [
        'name' => 'Vérificateur d’âge de domaine',
        'title' => 'Vérificateur d’âge de domaine : date d’enregistrement',
        'description' => 'Vérificateur d’âge de domaine gratuit : âge, expiration, bureau d’enregistrement et serveurs de noms de 20 domaines, via RDAP, le successeur du WHOIS.',
        'h1' => 'Vérificateur d’âge de domaine',
        'tagline' => 'Consultez l’âge exact, la date d’expiration et le bureau d’enregistrement de 20 domaines.',
        'keywords' => [
            'vérificateur d’âge de domaine',
            'âge d’un domaine',
            'date d’enregistrement d’un domaine',
            'quand un domaine a été enregistré',
            'recherche de domaine',
            'recherche rdap',
        ],
        'intro' => 'Un vérificateur d’âge de domaine consulte le registre officiel d’un nom de domaine pour afficher exactement son ancienneté. Entrez jusqu’à 20 domaines pour voir la date de création de chacun, son âge exact en années, mois et jours, sa date d’expiration, sa dernière mise à jour, son bureau d’enregistrement et ses serveurs de noms, obtenus en direct via RDAP, le successeur gratuit et sans clé du WHOIS. C’est utile pour étudier un site avant de l’acheter ou d’y créer un lien, vérifier depuis combien de temps une entreprise est en ligne, et suivre les dates de renouvellement de vos propres domaines.',
        'steps' => [
            'Entrez jusqu’à 20 domaines ou adresses de page, un par ligne.',
            'Cliquez sur Vérifier l’âge du domaine.',
            'Consultez l’âge, les dates, le bureau d’enregistrement et les serveurs de noms de chaque domaine, ou téléchargez les résultats en CSV.',
        ],
        'features' => [
            'Jusqu’à 20 domaines en une seule vérification',
            'Âge exact en années, mois et jours, ainsi que les dates de création, d’expiration et de dernière mise à jour',
            'Bureau d’enregistrement, codes de statut et serveurs de noms de chaque domaine',
            'Données en direct depuis RDAP, sans inscription, export CSV gratuit',
        ],
        'content' => [
            [
                'heading' => 'Qu’est-ce que le RDAP et en quoi diffère-t-il du WHOIS ?',
                'body' => 'Le RDAP (Registration Data Access Protocol) est le remplaçant moderne et standardisé du WHOIS. Là où le WHOIS renvoie du texte brut au format variable selon le registre, le RDAP renvoie du JSON structuré avec les mêmes noms de champs partout, est gratuit et sans clé, et prend en charge les noms de domaine internationalisés ainsi que des contrôles d’accès précis. L’ICANN a exigé que tous les bureaux d’enregistrement accrédités et les registres de gTLD proposent le RDAP, et des registres de domaines nationaux comme l’allemand DENIC ou le polonais NASK l’ont aussi ajouté : le WHOIS est donc progressivement remplacé par le RDAP.',
            ],
            [
                'heading' => 'Pourquoi certains domaines affichent-ils "non pris en charge" ou "aucun enregistrement trouvé" ?',
                'body' => 'Un petit nombre d’extensions de domaine nationales n’ont pas encore déployé de service RDAP, donc aucun registre ne peut être contacté pour elles ; elles affichent "non pris en charge". Un domaine peut aussi n’afficher aucun enregistrement s’il n’est pas enregistré actuellement, s’il a été enregistré très récemment et n’apparaît pas encore dans les données publiques du registre, ou si le registre est temporairement indisponible. Rien de tout cela ne signifie que le vérificateur se trompe : les dates affichées proviennent toujours directement de la réponse en direct du registre lui-même, jamais d’une estimation.',
            ],
        ],
        'faqs' => [
            [
                'q' => 'Comment vérifier l’ancienneté d’un domaine ?',
                'a' => 'Entrez le domaine ci-dessus et cliquez sur Vérifier l’âge du domaine. La date d’enregistrement exacte et l’âge en années, mois et jours proviennent directement de l’enregistrement RDAP du domaine.',
            ],
            [
                'q' => 'Est-ce la même information qu’une recherche WHOIS ?',
                'a' => 'Oui, ce sont les mêmes données d’enregistrement, mais lues via RDAP, le protocole structuré et sans clé qui remplace le WHOIS. Les dates, le bureau d’enregistrement et les serveurs de noms proviennent du même enregistrement dans les deux cas.',
            ],
            [
                'q' => 'Pourquoi la date d’expiration est-elle importante ?',
                'a' => 'Un domaine non renouvelé avant sa date d’expiration peut entrer dans une période de grâce puis être libéré pour que n’importe qui l’enregistre. Vérifier la date d’expiration d’un site est un moyen rapide de juger à quel point il est entretenu activement.',
            ],
            [
                'q' => 'Puis-je vérifier n’importe quelle extension de domaine ?',
                'a' => 'La plupart des extensions courantes (dont .com, .net, .org, .io, .co.uk, .de et .pl) ont un enregistrement RDAP. Un petit nombre d’extensions nationales plus confidentielles n’ont pas encore déployé le RDAP ; elles sont affichées comme non prises en charge plutôt que devinées.',
            ],
            [
                'q' => 'Quand un domaine a-t-il été enregistré ?',
                'a' => 'L’enregistrement RDAP d’un nom de domaine conserve une date de création : le jour exact où ce nom de domaine a été enregistré pour la première fois, même s’il a changé de propriétaire depuis. Entrez le domaine ci-dessus et le vérificateur lit cette date directement dans le registre, avec son âge en années, mois et jours.',
            ],
        ],
        'table' => [
            'caption' => 'Types d’événements RDAP affichés',
            'headers' => ['Champ', 'Événement RDAP', 'Signification'],
            'rows' => [
                ['Créé le', 'registration', 'Quand le domaine a été enregistré pour la première fois'],
                ['Expire le', 'expiration', 'Quand la période d’enregistrement actuelle se termine'],
                ['Dernière mise à jour', 'last changed', 'Quand l’enregistrement du registre a été modifié pour la dernière fois'],
            ],
        ],
    ],
    'rotate-pdf' => [
        'name' => 'Faire pivoter un PDF',
        'title' => 'Pivoter un PDF - Corrigez les Pages de Travers Gratuit',
        'description' => 'Faites pivoter un PDF de 90, 180 ou 270 degrés, gratuitement. Tout le document ou juste les pages choisies. Sans envoi, sans filigrane, sans inscription.',
        'h1' => 'Faire pivoter un PDF',
        'tagline' => 'Remettez à l\'endroit les pages de travers ou à l\'envers, directement dans votre navigateur.',
        'keywords' => ['pivoter pdf', 'faire pivoter un pdf', 'tourner pdf', 'pivoter pdf en ligne', 'corriger pdf de travers'],
        'intro' => 'Une page scannée ou une photo prise dans le mauvais sens se retrouve souvent de travers ou à l\'envers dans un PDF. Cet outil pour faire pivoter un PDF tourne les pages de 90, 180 ou 270 degrés pour qu\'elles se lisent dans le bon sens. Faites pivoter tout le document à la fois ou choisissez seulement les pages à corriger, puis téléchargez le fichier corrigé. Tout se passe sur votre appareil : votre PDF n\'est jamais envoyé sur un serveur.',
        'steps' => [
            'Choisissez le PDF à corriger.',
            'Cliquez sur une page pour la sélectionner, ou n\'en sélectionnez aucune pour faire pivoter tout le document.',
            'Cliquez sur 90°, 90° ou 180° pour faire pivoter les pages sélectionnées (ou toutes).',
            'Cliquez sur Pivoter le PDF et téléchargez le fichier corrigé.',
        ],
        'features' => [
            'Rotation de 90, 180 ou 270 degrés',
            'Faites pivoter tout le document ou seulement les pages choisies',
            'Les miniatures montrent le résultat avant le téléchargement',
            'Aucun filigrane et aucune perte de qualité',
            'Privé - votre PDF ne quitte jamais votre appareil',
        ],
        'content' => [
            ['heading' => 'Pourquoi les pages d\'un PDF se retrouvent-elles de travers ?', 'body' => 'Les scanners et les appareils photo des téléphones enregistrent parfois une page en orientation paysage dans un document par ailleurs en portrait, ce qui fait apparaître cette page de travers à la lecture du PDF. Faire pivoter seulement cette page, plutôt que tout le fichier, corrige le problème sans toucher au reste du document.'],
            ['heading' => 'La rotation modifie-t-elle le contenu de la page ?', 'body' => 'Non. La rotation ne change que l\'indicateur d\'orientation de la page, que chaque lecteur et imprimante PDF utilise pour l\'afficher correctement. Le texte, les images et la qualité de la page elle-même ne sont pas modifiés.'],
        ],
        'faqs' => [
            ['q' => 'Puis-je faire pivoter une seule page plutôt que tout le PDF ?', 'a' => 'Oui. Cliquez sur la miniature de la page (ou des pages) à corriger avant de cliquer sur un bouton de rotation ; seules les pages sélectionnées pivotent. Ne sélectionnez aucune page pour toutes les faire pivoter.'],
            ['q' => 'Quels angles de rotation sont disponibles ?', 'a' => 'Faites pivoter de 90 degrés vers la gauche ou la droite, ou retournez une page de 180 degrés si elle a été scannée à l\'envers. Vous pouvez combiner les clics pour obtenir n\'importe laquelle des quatre orientations.'],
            ['q' => 'Mon PDF est-il envoyé sur un serveur ?', 'a' => 'Non. Le PDF est ouvert et pivoté entièrement dans votre navigateur avec JavaScript et n\'est jamais envoyé où que ce soit.'],
            ['q' => 'Cela ajoute-t-il un filigrane ou réduit-il la qualité ?', 'a' => 'Non. La rotation ne change que l\'orientation de chaque page. Aucun filigrane, logo ou page supplémentaire n\'est ajouté, et aucune qualité d\'image ou de texte n\'est perdue.'],
        ],
    ],    'delete-pdf-pages' => [
        'name' => 'Supprimer des pages PDF',
        'title' => 'Supprimer des Pages PDF - Retirer des Pages Gratuit',
        'description' => 'Supprimez des pages d\'un PDF gratuitement en ligne. Cliquez sur les miniatures ou tapez des plages comme 2, 4-6. Sans envoi, sans filigrane, sans inscription.',
        'h1' => 'Supprimer des pages PDF',
        'tagline' => 'Retirez les pages dont vous n\'avez pas besoin, directement dans votre navigateur.',
        'keywords' => ['supprimer pages pdf', 'retirer pages pdf', 'supprimer une page pdf', 'enlever pages pdf en ligne', 'supprimer page d\'un pdf'],
        'intro' => 'Une page de garde vide, un scan dupliqué ou une page inutile peuvent être retirés d\'un PDF sans recréer tout le fichier. Cet outil supprime des pages d\'un PDF en cliquant sur leur miniature ou en tapant des plages comme 2, 4-6, puis enregistre un nouveau fichier avec seulement les pages que vous voulez garder. Tout se passe sur votre appareil, le PDF n\'est donc jamais envoyé.',
        'steps' => [
            'Choisissez le PDF à modifier.',
            'Cliquez sur la miniature de chaque page à supprimer, ou passez aux plages de pages et tapez des numéros comme 2, 4-6.',
            'Vérifiez les pages marquées pour suppression dans la grille.',
            'Cliquez sur Supprimer les pages et téléchargez le nouveau PDF.',
        ],
        'features' => [
            'Choisissez les pages par miniature ou en tapant des plages',
            'Les miniatures montrent exactement ce que vous allez retirer',
            'Il reste toujours au moins une page - impossible de tout supprimer par erreur',
            'Aucun filigrane et aucune perte de qualité sur les pages conservées',
            'Privé - votre PDF ne quitte jamais votre appareil',
        ],
        'content' => [
            ['heading' => 'Quand supprimer des pages plutôt que diviser', 'body' => 'Utilisez cet outil quand la majeure partie d\'un PDF convient et que seulement quelques pages doivent partir, comme une page vide, un doublon ou une ancienne page de garde. Si vous voulez plutôt extraire des pages précises dans leur propre fichier, le mode « Extraire des pages » de Diviser un PDF fait cela.'],
            ['heading' => 'Une page supprimée peut-elle être récupérée ?', 'body' => 'Pas dans le nouveau fichier - une fois téléchargé, les pages retirées disparaissent de cette copie. Conservez votre PDF original jusqu\'à être sûr que le résultat est correct, car rien ici n\'écrase le fichier sur votre appareil.'],
        ],
        'faqs' => [
            ['q' => 'Comment supprimer plusieurs pages à la fois ?', 'a' => 'Cliquez sur la miniature de chaque page à marquer, ou passez à « Plages de pages » et tapez quelque chose comme 2, 4-6 pour en marquer plusieurs d\'un coup.'],
            ['q' => 'Puis-je supprimer toutes les pages du PDF ?', 'a' => 'Non. Il doit en rester au moins une, donc le bouton Supprimer les pages reste désactivé si votre sélection les supprimerait toutes.'],
            ['q' => 'Mon PDF est-il envoyé où que ce soit ?', 'a' => 'Non. Les pages sont supprimées entièrement dans votre navigateur avec JavaScript, et le fichier n\'est jamais envoyé à un serveur.'],
            ['q' => 'Les pages restantes perdent-elles en qualité ?', 'a' => 'Non. Les pages conservées sont copiées exactement telles quelles, sans recompression, filigrane ni page ajoutée.'],
        ],
    ],    'organize-pdf' => [
        'name' => 'Organiser un PDF',
        'title' => 'Organiser un PDF - Réordonner les Pages Gratuit',
        'description' => 'Réordonnez les pages d\'un PDF gratuitement. Glissez les miniatures dans un nouvel ordre, ou utilisez les boutons de déplacement, sans filigrane ni inscription.',
        'h1' => 'Organiser un PDF',
        'tagline' => 'Glissez les pages dans l\'ordre souhaité, directement dans votre navigateur.',
        'keywords' => ['organiser pdf', 'réordonner pages pdf', 'changer ordre pages pdf', 'trier pages pdf', 'réorganiser pdf'],
        'intro' => 'Les pages se retrouvent parfois dans le mauvais ordre après un scan ou la fusion de plusieurs documents. Cet outil organise un PDF en vous laissant glisser les miniatures des pages dans un nouvel ordre, ou les déplacer avec les boutons flèches si vous préférez ne pas glisser. Une fois l\'ordre correct, enregistrez un nouveau PDF avec les pages réorganisées. Tout se passe sur votre appareil, le fichier n\'est donc jamais envoyé.',
        'steps' => [
            'Choisissez le PDF à réorganiser.',
            'Faites glisser la miniature d\'une page vers sa nouvelle position, ou utilisez les boutons ← et →.',
            'Répétez jusqu\'à ce que les pages soient dans l\'ordre souhaité.',
            'Cliquez sur Enregistrer le nouvel ordre et téléchargez le PDF réorganisé.',
        ],
        'features' => [
            'Glissez-déposez les miniatures pour les réordonner',
            'Les boutons de déplacement fonctionnent sans souris, pour le clavier',
            'Les numéros de page se mettent à jour en direct',
            'Aucun filigrane et aucune perte de qualité',
            'Privé - votre PDF ne quitte jamais votre appareil',
        ],
        'content' => [
            ['heading' => 'Quand réordonner des pages', 'body' => 'Un cas fréquent est de scanner une pile de papier qui sort dans le mauvais ordre, ou de fusionner deux PDF où l\'un doit s\'insérer au milieu de l\'autre. Plutôt que de tout recommencer, cet outil vous permet de corriger directement l\'ordre d\'un PDF existant.'],
            ['heading' => 'Réordonner sans souris', 'body' => 'Chaque miniature de page a des boutons « déplacer plus tôt » et « déplacer plus tard », donc les pages peuvent être réordonnées au clavier ou à l\'écran tactile aussi facilement qu\'en glissant.'],
        ],
        'faqs' => [
            ['q' => 'Puis-je réordonner les pages sans les glisser ?', 'a' => 'Oui. Chaque miniature a des boutons ← et → qui la déplacent d\'une position plus tôt ou plus tard, et qui fonctionnent aussi au clavier.'],
            ['q' => 'Réordonner change-t-il le contenu d\'une page ?', 'a' => 'Non. Les pages sont copiées exactement telles quelles ; seule leur position dans le document change.'],
            ['q' => 'Mon PDF est-il envoyé sur un serveur ?', 'a' => 'Non. Le PDF est ouvert et réordonné entièrement dans votre navigateur avec JavaScript et n\'est jamais envoyé où que ce soit.'],
            ['q' => 'Puis-je aussi supprimer ou pivoter des pages ici ?', 'a' => 'Cet outil réordonne seulement les pages. Utilisez Supprimer des Pages PDF ou Pivoter un PDF pour cela, avant ou après avoir organisé l\'ordre.'],
        ],
    ],    'pdf-to-jpg' => [
        'name' => 'PDF en JPG',
        'title' => 'Convertisseur PDF en JPG - Convertir Gratuitement',
        'description' => 'Convertissez les pages d\'un PDF en JPG gratuitement. Choisissez 72, 150 ou 300 DPI et téléchargez une image ou un ZIP, sans filigrane ni inscription.',
        'h1' => 'PDF en JPG',
        'tagline' => 'Transformez les pages d\'un PDF en images JPG, directement dans votre navigateur.',
        'keywords' => ['pdf en jpg', 'convertisseur pdf en jpg', 'convertir pdf en jpg', 'pdf en image', 'page pdf en jpg'],
        'intro' => 'Un convertisseur PDF en JPG transforme chaque page d\'un PDF en image JPG, utile pour partager une page sur les réseaux sociaux, la coller dans un document ou la visualiser où les PDF ne sont pas pris en charge. Choisissez une résolution de 72, 150 ou 300 DPI, puis convertissez : un PDF d\'une page se télécharge en un seul JPG, et un PDF de plusieurs pages se télécharge en un ZIP d\'images numérotées. Tout se passe sur votre appareil, le PDF n\'est donc jamais envoyé.',
        'steps' => [
            'Choisissez le PDF à convertir.',
            'Choisissez une qualité d\'image : 72 DPI pour les écrans, 150 pour un usage général, ou 300 DPI pour l\'impression.',
            'Cliquez sur Convertir.',
            'Téléchargez le JPG, ou le fichier ZIP si le PDF compte plusieurs pages.',
        ],
        'features' => [
            'Choisissez 72, 150 ou 300 DPI',
            'Les PDF d\'une page se téléchargent en un seul JPG',
            'Les PDF de plusieurs pages se téléchargent en un ZIP d\'images numérotées',
            'Les miniatures confirment que vous avez choisi le bon fichier',
            'Privé - votre PDF ne quitte jamais votre appareil',
        ],
        'content' => [
            ['heading' => 'Quel DPI choisir ?', 'body' => '72 DPI correspond à un écran classique et donne le plus petit fichier, idéal pour un aperçu rapide ou un usage web. 150 DPI est un bon choix général pour partager ou coller dans des documents. 300 DPI produit une image plus nette et plus grande, adaptée à l\'impression ou au zoom sur du texte fin.'],
            ['heading' => 'PDF en JPG ou PDF en PNG', 'body' => 'Le JPG utilise une compression avec perte, ce qui donne des fichiers plus petits et convient aux pages scannées ou aux photos. Le PNG est sans perte et convient mieux aux pages avec du texte net, des tableaux ou des traits, au prix d\'un fichier plus volumineux. Utilisez PDF en PNG quand la qualité d\'image compte plus que la taille du fichier.'],
        ],
        'faqs' => [
            ['q' => 'Puis-je convertir toutes les pages d\'un PDF en JPG en une fois ?', 'a' => 'Oui. La conversion traite toutes les pages ; s\'il y en a plusieurs, les images sont regroupées dans un seul fichier ZIP à télécharger.'],
            ['q' => 'Quel DPI utiliser pour l\'impression ?', 'a' => '300 DPI donne un résultat net pour l\'impression. 150 DPI suffit pour la plupart des écrans, et 72 DPI donne le fichier le plus petit, idéal pour un aperçu rapide.'],
            ['q' => 'Mon PDF est-il envoyé sur un serveur ?', 'a' => 'Non. Les pages sont converties en images entièrement dans votre navigateur avec JavaScript, et le fichier n\'est jamais envoyé où que ce soit.'],
            ['q' => 'Puis-je convertir une seule page plutôt que tout le PDF ?', 'a' => 'Cet outil convertit toutes les pages. Pour n\'en obtenir qu\'une, utilisez d\'abord le mode « Extraire des pages » de Diviser un PDF, puis convertissez ici le PDF d\'une page obtenu.'],
        ],
    ],
    'pdf-to-png' => [
        'name' => 'PDF en PNG',
        'title' => 'Convertisseur PDF en PNG - Convertir Gratuitement',
        'description' => 'Convertissez les pages d\'un PDF en PNG gratuitement. Choisissez 72, 150 ou 300 DPI et téléchargez une image ou un ZIP, sans filigrane ni inscription.',
        'h1' => 'PDF en PNG',
        'tagline' => 'Transformez les pages d\'un PDF en images PNG nettes, directement dans votre navigateur.',
        'keywords' => ['pdf en png', 'convertisseur pdf en png', 'convertir pdf en png', 'page pdf en png', 'pdf en image png'],
        'intro' => 'Un convertisseur PDF en PNG transforme chaque page d\'un PDF en image PNG sans perte, qui garde le texte, les tableaux et les traits bien nets. Choisissez une résolution de 72, 150 ou 300 DPI, puis convertissez : un PDF d\'une page se télécharge en un seul PNG, et un PDF de plusieurs pages se télécharge en un ZIP d\'images numérotées. Tout se passe sur votre appareil, le PDF n\'est donc jamais envoyé.',
        'steps' => [
            'Choisissez le PDF à convertir.',
            'Choisissez une qualité d\'image : 72 DPI pour les écrans, 150 pour un usage général, ou 300 DPI pour l\'impression.',
            'Cliquez sur Convertir.',
            'Téléchargez le PNG, ou le fichier ZIP si le PDF compte plusieurs pages.',
        ],
        'features' => [
            'Choisissez 72, 150 ou 300 DPI',
            'Sortie PNG sans perte, nette pour le texte et les traits',
            'Les PDF d\'une page se téléchargent en un seul PNG',
            'Les PDF de plusieurs pages se téléchargent en un ZIP d\'images numérotées',
            'Privé - votre PDF ne quitte jamais votre appareil',
        ],
        'content' => [
            ['heading' => 'Quel DPI choisir ?', 'body' => '72 DPI correspond à un écran classique et donne le plus petit fichier, idéal pour un aperçu rapide ou un usage web. 150 DPI est un bon choix général pour partager ou coller dans des documents. 300 DPI produit une image plus nette et plus grande, adaptée à l\'impression ou au zoom sur du texte fin.'],
            ['heading' => 'PDF en PNG ou PDF en JPG', 'body' => 'Le PNG est sans perte, ce qui garde le texte, les tableaux et les diagrammes nets, au prix d\'un fichier plus volumineux. Le JPG utilise une compression avec perte pour des fichiers plus petits et convient aux pages scannées ou aux photos. Utilisez PDF en JPG quand la taille du fichier compte plus que la qualité exacte des pixels.'],
        ],
        'faqs' => [
            ['q' => 'Pourquoi choisir PNG plutôt que JPG ?', 'a' => 'Le PNG est sans perte, le texte net, les tableaux et les diagrammes restent donc propres sans artefacts de compression. Les fichiers JPG sont souvent plus petits mais peuvent flouter les détails fins.'],
            ['q' => 'Puis-je convertir toutes les pages d\'un PDF en PNG en une fois ?', 'a' => 'Oui. La conversion traite toutes les pages ; s\'il y en a plusieurs, les images sont regroupées dans un seul fichier ZIP à télécharger.'],
            ['q' => 'Mon PDF est-il envoyé sur un serveur ?', 'a' => 'Non. Les pages sont converties en images entièrement dans votre navigateur avec JavaScript, et le fichier n\'est jamais envoyé où que ce soit.'],
            ['q' => 'Quel DPI utiliser pour l\'impression ?', 'a' => '300 DPI donne un résultat net pour l\'impression. 150 DPI suffit pour la plupart des écrans, et 72 DPI donne le fichier le plus petit, idéal pour un aperçu rapide.'],
        ],
    ],

    'compress-pdf' => [
        'name' => 'Compresser le PDF',
        'title' => 'Compresser un PDF - Réduire sa Taille Gratuitement',
        'description' => 'Compressez un PDF en ligne gratuitement pour réduire sa taille. Le mode Recommandé garde le texte sélectionnable ; le mode Fort réduit davantage. Sans upload.',
        'h1' => 'Compresser le PDF',
        'tagline' => 'Rendez un PDF plus léger sans perdre en lisibilité, directement dans votre navigateur.',
        'keywords' => [
            'compresser pdf',
            'compresseur pdf',
            'réduire la taille d\'un pdf',
            'alléger un pdf',
            'compresser pdf en ligne',
        ],
        'intro' => 'Un outil de compression de PDF réduit la taille d\'un fichier PDF en diminuant le poids des images qu\'il contient, pour qu\'il soit plus facile à envoyer par e-mail, à téléverser ou à stocker. Le mode Recommandé recompresse les photos intégrées à une qualité moindre tout en gardant le texte net et sélectionnable. Le mode Fort va plus loin en transformant chaque page en une seule image, ce qui donne le fichier le plus léger possible mais empêche de sélectionner ou de rechercher le texte. Tout se passe sur votre appareil, votre PDF n\'est donc jamais envoyé à un serveur.',
        'steps' => [
            'Choisissez le PDF à compresser.',
            'Choisissez Recommandé pour réduire les images en gardant le texte sélectionnable, ou Fort pour le fichier le plus léger possible.',
            'En mode Fort, choisissez une qualité d\'image (DPI).',
            'Cliquez sur Compresser le PDF et téléchargez le fichier allégé.',
        ],
        'features' => [
            'Le mode Recommandé garde le texte sélectionnable et recherchable',
            'Le mode Fort donne le fichier le plus léger en transformant les pages en images',
            'Affiche la taille avant et après, pour voir le gain',
            'Conserve le fichier original si la compression ne le rendrait pas plus léger',
            'Confidentiel - votre PDF ne quitte jamais votre appareil',
        ],
        'content' => [
            [
                'heading' => 'Recommandé ou Fort - lequel choisir ?',
                'body' => 'Le mode Recommandé ne recompresse que les photos et images scannées du PDF : les titres, paragraphes et tableaux restent exactement identiques et peuvent toujours être sélectionnés, recherchés et copiés. Le mode Fort convertit chaque page en une seule image JPEG, ce qui donne généralement un fichier bien plus léger mais empêche ensuite de sélectionner, rechercher ou copier le moindre texte - idéal pour les documents riches en photos qui ont juste besoin d\'être plus légers à partager.',
            ],
            [
                'heading' => 'Pourquoi mon PDF n\'est-il pas devenu plus léger ?',
                'body' => 'Un PDF composé uniquement de texte et de graphiques vectoriels, ou déjà compressé, peut ne pas rétrécir davantage en mode Recommandé car il ne reste pas de grandes images à recompresser. Dans ce cas, le fichier original est conservé afin que vous n\'obteniez jamais un résultat plus lourd que le départ, et le mode Fort peut encore le réduire en transformant les pages en images.',
            ],
        ],
        'faqs' => [
            [
                'q' => 'Compresser un PDF réduit-il sa qualité ?',
                'a' => 'Le mode Recommandé réduit légèrement la qualité des photos intégrées, un peu comme enregistrer un JPEG avec un réglage plus bas, tandis que le texte et les graphiques vectoriels restent nets. Le mode Fort transforme toute la page en image, donc un texte très petit peut paraître moins net en zoomant.',
            ],
            [
                'q' => 'Pourrai-je encore sélectionner le texte après compression ?',
                'a' => 'Oui, avec le mode Recommandé. Le mode Fort transforme chaque page en une seule image, le texte ne peut alors plus être sélectionné, recherché ni copié - ne le choisissez que lorsque la taille du fichier compte plus que cela.',
            ],
            [
                'q' => 'Que se passe-t-il si le fichier compressé n\'est pas plus léger ?',
                'a' => 'Le fichier original est conservé et proposé au téléchargement sans modification, vous ne vous retrouvez donc jamais avec un résultat plus lourd que celui de départ.',
            ],
            [
                'q' => 'Mon PDF est-il envoyé à un serveur ?',
                'a' => 'Non. La compression se fait entièrement dans votre navigateur avec JavaScript, et le fichier n\'est jamais envoyé nulle part.',
            ],
        ],
    ],

    'protect-pdf' => [
        'name' => 'Protéger le PDF',
        'title' => 'Protéger un PDF - Ajouter un Mot de Passe Gratuit',
        'description' => 'Ajoutez un vrai mot de passe à un PDF en ligne gratuitement, avec un chiffrement AES-256. Seul qui le connaît peut ouvrir le fichier. Sans upload.',
        'h1' => 'Protéger le PDF',
        'tagline' => 'Verrouillez un PDF avec un mot de passe pour que seules les personnes qui le connaissent puissent l\'ouvrir.',
        'keywords' => [
            'protéger pdf',
            'mettre un mot de passe sur un pdf',
            'ajouter un mot de passe à un pdf',
            'chiffrer pdf',
            'mot de passe pdf en ligne',
        ],
        'intro' => 'Protéger un PDF ajoute un mot de passe afin que le fichier ne puisse être ouvert que par une personne qui le connaît. Cet outil chiffre votre PDF avec un vrai chiffrement AES-256, la même robustesse utilisée par les systèmes bancaires et gouvernementaux, directement dans votre navigateur. Choisissez un mot de passe, confirmez-le, puis téléchargez une copie du PDF qui demandera ce mot de passe avant de s\'ouvrir dans n\'importe quel lecteur de PDF.',
        'steps' => [
            'Choisissez le PDF à protéger.',
            'Saisissez un mot de passe et confirmez-le.',
            'Cliquez sur Protéger le PDF.',
            'Téléchargez la copie protégée par mot de passe.',
        ],
        'features' => [
            'Un vrai chiffrement AES-256, pas juste une astuce de nom de fichier',
            'S\'ouvre uniquement avec le mot de passe que vous avez choisi',
            'Fonctionne avec tout lecteur de PDF compatible avec le chiffrement PDF standard',
            'Traité entièrement dans votre navigateur - le PDF n\'est jamais envoyé',
            'Sans filigrane, sans limite de pages',
        ],
        'content' => [
            [
                'heading' => 'Le chiffrement est-il vraiment solide ?',
                'body' => 'Le PDF est chiffré en AES-256, l\'algorithme largement utilisé pour protéger les données sensibles, via la bibliothèque open source QPDF exécutée dans votre navigateur sous forme de WebAssembly. Sans le mot de passe, le contenu du fichier ne peut pas être lu par un lecteur de PDF.',
            ],
            [
                'heading' => 'Et si j\'oublie le mot de passe ?',
                'body' => 'Il n\'existe aucun moyen de récupérer un mot de passe oublié sur un PDF protégé en AES-256, c\'est voulu : c\'est ce qui rend la protection efficace. Conservez une copie du mot de passe en lieu sûr, comme un gestionnaire de mots de passe, et gardez le fichier original non protégé jusqu\'à être sûr de vous en souvenir.',
            ],
        ],
        'faqs' => [
            [
                'q' => 'Est-ce que cela envoie mon PDF quelque part ?',
                'a' => 'Non. Le fichier est chiffré entièrement dans votre navigateur avec JavaScript grâce à une version de QPDF compilée en WebAssembly, et ne quitte jamais votre appareil.',
            ],
            [
                'q' => 'Quel chiffrement est utilisé ?',
                'a' => 'AES-256, la norme moderne pour le chiffrement des PDF, appliquée avec la bibliothèque open source QPDF compilée pour s\'exécuter dans le navigateur.',
            ],
            [
                'q' => 'Puis-je retirer le mot de passe plus tard ?',
                'a' => 'Oui. Utilisez l\'outil Déverrouiller le PDF avec le mot de passe que vous avez défini pour obtenir une copie sans lui.',
            ],
            [
                'q' => 'Le PDF protégé s\'ouvrira-t-il dans n\'importe quel lecteur ?',
                'a' => 'Oui. Il utilise le format de chiffrement PDF standard pris en charge par Adobe Acrobat, les navigateurs et la plupart des autres lecteurs de PDF, qui demanderont le mot de passe avant de l\'ouvrir.',
            ],
        ],
    ],

    'unlock-pdf' => [
        'name' => 'Déverrouiller le PDF',
        'title' => 'Déverrouiller un PDF - Retirer le Mot de Passe',
        'description' => 'Retirez le mot de passe d\'un PDF en ligne gratuitement si vous le connaissez. Saisissez-le une fois et téléchargez une copie déverrouillée. Sans upload.',
        'h1' => 'Déverrouiller le PDF',
        'tagline' => 'Retirez le mot de passe d\'un PDF que vous connaissez déjà, directement dans votre navigateur.',
        'keywords' => [
            'déverrouiller pdf',
            'retirer mot de passe pdf',
            'supprimer mot de passe pdf',
            'déchiffrer pdf',
            'enlever mot de passe pdf',
        ],
        'intro' => 'Déverrouiller un PDF retire son mot de passe d\'ouverture afin qu\'il ne soit plus demandé à chaque ouverture. Cet outil ne retire qu\'un mot de passe que vous connaissez déjà - saisissez-le une fois, et une nouvelle copie du PDF est créée sans lui. Il ne casse, ne devine ni ne contourne un mot de passe que vous ne possédez pas, car cela rendrait la protection inutile.',
        'steps' => [
            'Choisissez le PDF protégé par mot de passe.',
            'Saisissez le mot de passe.',
            'Cliquez sur Déverrouiller le PDF.',
            'Téléchargez la copie sans mot de passe.',
        ],
        'features' => [
            'Retire le mot de passe d\'ouverture d\'un PDF que vous pouvez déjà ouvrir',
            'Ne casse, ne devine ni ne contourne les mots de passe inconnus',
            'Fonctionne entièrement dans votre navigateur - le PDF n\'est jamais envoyé',
            'Téléchargez un PDF normal qui s\'ouvre sans rien demander',
            'Sans filigrane, sans limite de pages',
        ],
        'content' => [
            [
                'heading' => 'Pourquoi dois-je saisir le mot de passe ?',
                'body' => 'Cet outil déchiffre un PDF à l\'aide du même mot de passe qui l\'ouvre déjà, plutôt que de tenter de casser le chiffrement. Si vous ne connaissez pas le mot de passe, cet outil ne peut pas vous aider - il n\'existe aucun moyen fiable ou responsable de le récupérer.',
            ],
            [
                'heading' => 'Est-ce différent de Protéger le PDF ?',
                'body' => 'Protéger le PDF ajoute un mot de passe à un PDF qui n\'en a pas. Déverrouiller le PDF fait l\'inverse : il retire un mot de passe d\'un PDF qui en a déjà un, à condition que vous le fournissiez.',
            ],
        ],
        'faqs' => [
            [
                'q' => 'Cet outil peut-il casser ou deviner le mot de passe d\'un PDF ?',
                'a' => 'Non. Il ne retire qu\'un mot de passe que vous saisissez vous-même. Si vous ne connaissez pas le mot de passe, aucun outil, celui-ci ou un autre, ne peut légitimement le récupérer pour vous.',
            ],
            [
                'q' => 'Mon PDF est-il envoyé quelque part ?',
                'a' => 'Non. Le mot de passe est vérifié et retiré entièrement dans votre navigateur grâce à une version de la bibliothèque open source QPDF compilée en WebAssembly, et le fichier ne quitte jamais votre appareil.',
            ],
            [
                'q' => 'Que se passe-t-il si je saisis le mauvais mot de passe ?',
                'a' => 'Un message « Mot de passe incorrect » s\'affiche et vous pouvez réessayer. Le fichier lui-même n\'est jamais modifié tant que le bon mot de passe ne l\'a pas déverrouillé avec succès.',
            ],
            [
                'q' => 'Le déverrouillage modifie-t-il autre chose dans le PDF ?',
                'a' => 'Non. Seule la protection par mot de passe est retirée ; les pages, le texte et les images restent exactement identiques.',
            ],
        ],
    ],

    'pdf-to-word' => [
        'name' => 'PDF en Word',
        'title' => 'Convertisseur PDF en Word - Gratuit et Privé',
        'description' => 'Convertissez un PDF en Word en ligne gratuitement. Le texte, les paragraphes et les titres deviennent un fichier .docx modifiable, créé dans votre navigateur.',
        'h1' => 'Convertisseur PDF en Word',
        'tagline' => 'Transformez un PDF en document Word modifiable, directement dans votre navigateur.',
        'keywords' => [
            'pdf en word',
            'convertir pdf en word',
            'convertisseur pdf en word',
            'pdf en docx',
            'pdf en word gratuit',
        ],
        'intro' => 'Un convertisseur PDF en Word transforme le texte d\'un PDF en un fichier .docx modifiable que vous pouvez ouvrir dans Microsoft Word, Google Docs ou LibreOffice. Cet outil lit le texte de votre PDF et le reconstruit sous forme de paragraphes et de titres, pour que vous puissiez modifier le contenu sans tout retaper. Le PDF est lu entièrement dans votre navigateur et n\'est jamais envoyé à un serveur.',
        'steps' => [
            'Choisissez ou déposez le PDF à convertir.',
            'Cliquez sur Convertir en Word.',
            'Téléchargez le fichier .docx et ouvrez-le dans Word, Google Docs ou LibreOffice.',
        ],
        'features' => [
            'Extrait le texte en paragraphes réellement modifiables',
            'Détecte les titres selon la taille du texte, à titre d\'estimation',
            'Conserve les retours à la ligne et l\'ordre de lecture',
            'Privé : le PDF n\'est jamais envoyé',
            'Pas d\'inscription, pas de filigrane',
        ],
        'content' => [
            [
                'heading' => 'Ce qui est converti, et ce qui ne l\'est pas',
                'body' => 'Un PDF n\'a pas de vraie structure de paragraphes, de tableaux ou de titres : seulement du texte positionné sur une page. Cet outil reconstruit des paragraphes et des titres à partir de ce texte, ce qui fonctionne bien pour des documents simples comme des lettres, des rapports ou des articles. Les tableaux, les mises en page à plusieurs colonnes, les zones de texte, les images et les polices ou espacements exacts ne sont pas conservés : le résultat est un document lisible et modifiable, pas une copie exacte au pixel près.',
            ],
            [
                'heading' => 'Pourquoi un PDF scanné ne peut-il pas être converti ?',
                'body' => 'Un PDF scanné est en réalité une photographie d\'une page, sans texte sélectionnable en dessous que le navigateur puisse lire. Le convertir nécessiterait d\'abord l\'OCR (reconnaissance optique de caractères) pour reconnaître les lettres, ce que cet outil ne fait pas ; si votre lecteur de PDF vous permet de sélectionner et copier le texte, la conversion devrait fonctionner normalement.',
            ],
        ],
        'faqs' => [
            ['q' => 'La mise en forme sera-t-elle exactement la même que dans le PDF d\'origine ?', 'a' => 'Pas exactement. Le texte, les titres de base et les retours à la ligne sont conservés, mais les tableaux, colonnes, images et polices ou espacements exacts ne le sont pas. L\'objectif est de vous donner du texte modifiable, pas une copie au pixel près.'],
            ['q' => 'Puis-je convertir un PDF scanné ?', 'a' => 'Seulement s\'il contient déjà du texte sélectionnable. Une page scannée sans couche de texte n\'a rien que cet outil puisse extraire, puisqu\'il ne fait pas d\'OCR.'],
            ['q' => 'Mon PDF est-il envoyé quelque part ?', 'a' => 'Non. Toute la conversion se fait dans votre navigateur avec JavaScript, et le fichier ne quitte jamais votre appareil.'],
            ['q' => 'Quel fichier obtiens-je ?', 'a' => 'Un fichier .docx standard qui s\'ouvre dans Microsoft Word, Google Docs, LibreOffice Writer et la plupart des autres traitements de texte.'],
        ],
    ],

    'word-to-pdf' => [
        'name' => 'Word en PDF',
        'title' => 'Convertisseur Word en PDF - Gratuit et Privé',
        'description' => 'Convertissez un document Word (.docx) en PDF en ligne gratuitement. Garde titres, paragraphes, listes, gras/italique et images, dans votre navigateur.',
        'h1' => 'Convertisseur Word en PDF',
        'tagline' => 'Transformez un document Word en PDF, en toute confidentialité dans votre navigateur.',
        'keywords' => [
            'word en pdf',
            'convertir word en pdf',
            'docx en pdf',
            'convertisseur word en pdf',
            'word en pdf gratuit',
        ],
        'intro' => 'Convertir Word en PDF transforme un fichier .docx modifiable en un PDF figé qui s\'affiche de la même façon sur tous les appareils et ne peut pas être facilement modifié. Cet outil lit votre document Word et reconstruit ses titres, paragraphes, listes, texte en gras ou italique et images sous forme d\'un nouveau PDF, tout cela dans votre navigateur : le document n\'est jamais envoyé où que ce soit.',
        'steps' => [
            'Choisissez ou déposez le fichier Word (.docx) à convertir.',
            'Choisissez le format de page A4 ou Lettre.',
            'Cliquez sur Convertir en PDF et téléchargez le résultat.',
        ],
        'features' => [
            'Conserve les titres, paragraphes et retours à la ligne',
            'Conserve les listes à puces et numérotées',
            'Conserve le texte en gras et en italique',
            'Conserve les images du document',
            'Privé : votre document n\'est jamais envoyé',
        ],
        'content' => [
            [
                'heading' => 'Ce qui est conservé, et ce qui ne l\'est pas',
                'body' => 'Les titres, paragraphes, retours à la ligne, listes à puces et numérotées, texte en gras et en italique, et la plupart des images sont reconstruits dans le PDF. Les tableaux, mises en page à plusieurs colonnes, zones de texte, en-têtes et pieds de page, suivi des modifications, ainsi que les polices ou la position exactes du document Word original ne sont pas conservés : le résultat garde le contenu et l\'ordre de lecture plutôt que de reproduire la page au pixel près.',
            ],
            [
                'heading' => 'Seuls les fichiers .docx sont pris en charge',
                'body' => 'Cet outil lit le format moderne de Word (.docx). L\'ancien format .doc de Word 2003 et antérieur n\'est pas pris en charge ; ouvrez-le dans Word et utilisez « Enregistrer sous » pour créer d\'abord une copie .docx.',
            ],
        ],
        'faqs' => [
            ['q' => 'Mon document Word ressemblera-t-il exactement au PDF ?', 'a' => 'Les titres, paragraphes, listes, gras/italique et images sont conservés, mais les tableaux, colonnes, zones de texte et polices ou espacements exacts ne le sont pas. Pour la plupart des lettres, rapports et articles, le résultat ressemble beaucoup à l\'original.'],
            ['q' => 'Cela fonctionne-t-il avec les fichiers .doc ?', 'a' => 'Non, uniquement avec le format moderne .docx. Les anciens fichiers .doc doivent d\'abord être enregistrés en .docx dans Word.'],
            ['q' => 'Mon document est-il envoyé quelque part ?', 'a' => 'Non. Toute la conversion se fait dans votre navigateur avec JavaScript, et le fichier ne quitte jamais votre appareil.'],
            ['q' => 'Quel format de page le PDF utilise-t-il ?', 'a' => 'Choisissez A4 ou Lettre avant de convertir ; le contenu s\'adapte au format choisi.'],
        ],
    ],

    'excel-to-pdf' => [
        'name' => 'Excel en PDF',
        'title' => 'Convertisseur Excel en PDF - Gratuit et Privé',
        'description' => 'Convertissez Excel (.xlsx, .xls) ou CSV en PDF en ligne gratuitement. Chaque feuille devient un tableau clair et paginé, sans envoi : tout dans le navigateur.',
        'h1' => 'Convertisseur Excel en PDF',
        'tagline' => 'Transformez une feuille de calcul en un tableau PDF clair et paginé.',
        'keywords' => [
            'excel en pdf',
            'convertir excel en pdf',
            'xlsx en pdf',
            'feuille de calcul en pdf',
            'csv en pdf',
        ],
        'intro' => 'Un convertisseur Excel en PDF transforme une feuille de calcul en un document figé qui s\'ouvre de la même façon sur tout appareil, sans avoir besoin d\'Excel installé. Cet outil lit votre fichier .xlsx, .xls ou .csv et dessine chaque feuille comme un tableau avec bordures, le divisant sur autant de pages que nécessaire, avec la ligne d\'en-tête répétée sur chaque page. Le fichier est lu entièrement dans votre navigateur et n\'est jamais envoyé.',
        'steps' => [
            'Choisissez ou déposez votre fichier Excel (.xlsx, .xls) ou CSV.',
            'Choisissez le format de page et l\'orientation (portrait ou paysage).',
            'Cliquez sur Convertir en PDF et téléchargez le résultat.',
        ],
        'features' => [
            'Convertit les fichiers .xlsx, .xls et .csv',
            'Chaque feuille devient son propre tableau, avec l\'en-tête répété sur chaque page',
            'Portrait ou paysage, A4 ou Lettre',
            'Les colonnes s\'ajustent automatiquement au contenu',
            'Privé : votre feuille de calcul n\'est jamais envoyée',
        ],
        'content' => [
            [
                'heading' => 'À quoi ressemble une feuille large dans le PDF',
                'body' => 'Les colonnes s\'ajustent à leur contenu et sont réduites pour tenir dans la largeur de la page si possible. Si une feuille a encore trop de colonnes, le texte qui ne tient pas dans sa colonne est raccourci avec des points de suspension (« … ») plutôt que de chevaucher la colonne suivante. Passer en orientation paysage donne généralement plus de place aux feuilles larges.',
            ],
            [
                'heading' => 'Ce qui n\'est pas conservé',
                'body' => 'Cet outil se concentre sur la clarté des données sur la page : les couleurs de fond de cellule, les polices personnalisées, les formules (la dernière valeur calculée est utilisée à la place), les graphiques et les cellules fusionnées ne sont pas conservés.',
            ],
        ],
        'faqs' => [
            ['q' => 'Puis-je aussi convertir un fichier CSV ?', 'a' => 'Oui. Les fichiers CSV fonctionnent comme les .xlsx et .xls : choisissez le fichier et il devient un tableau PDF sur une seule feuille.'],
            ['q' => 'Que se passe-t-il pour une feuille avec beaucoup de colonnes ?', 'a' => 'La largeur des colonnes est réduite pour tenir sur la page, et passer en orientation paysage donne plus de place aux tableaux larges. Le texte qui ne tient toujours pas dans sa colonne est raccourci avec « … ».'],
            ['q' => 'Les formules ou les graphiques sont-ils conservés ?', 'a' => 'Les formules affichent leur dernière valeur calculée sous forme de texte, pas la formule elle-même, et les graphiques ne sont pas inclus dans le PDF.'],
            ['q' => 'Ma feuille de calcul est-elle envoyée quelque part ?', 'a' => 'Non. Toute la conversion se fait dans votre navigateur avec JavaScript, et le fichier ne quitte jamais votre appareil.'],
        ],
    ],

    'pdf-to-excel' => [
        'name' => 'PDF en Excel',
        'title' => 'Convertisseur PDF en Excel - Gratuit et Privé',
        'description' => 'Convertissez un PDF en Excel en ligne gratuitement. Le texte est regroupé en lignes et colonnes, de façon estimée, dans un fichier .xlsx.',
        'h1' => 'Convertisseur PDF en Excel',
        'tagline' => 'Transformez les tableaux d\'un PDF en feuille de calcul, de façon approximative.',
        'keywords' => [
            'pdf en excel',
            'convertir pdf en excel',
            'pdf en xlsx',
            'pdf en feuille de calcul',
            'tableau pdf en excel',
        ],
        'intro' => 'Un PDF n\'a pas de vraies lignes ni colonnes, seulement du texte positionné sur une page, donc le transformer en feuille de calcul reste toujours une estimation. Cet outil regroupe le texte qui partage la même position verticale en une ligne, puis aligne les positions horizontales similaires sur la page en colonnes, et enregistre le résultat en fichier .xlsx avec une feuille par page. Cela fonctionne mieux sur des PDF qui ressemblent déjà à un tableau, comme des factures ou des rapports exportés, et tout se lit dans votre navigateur.',
        'steps' => [
            'Choisissez ou déposez le PDF à convertir.',
            'Cliquez sur Convertir en Excel.',
            'Téléchargez le fichier .xlsx et ouvrez-le dans Excel, Google Sheets ou LibreOffice Calc.',
        ],
        'features' => [
            'Regroupe automatiquement le texte en lignes et colonnes',
            'Une feuille par page du PDF',
            'Fonctionne bien sur les factures et rapports exportés déjà tabulaires',
            'Privé : le PDF n\'est jamais envoyé',
            'Pas d\'inscription, pas de filigrane',
        ],
        'content' => [
            [
                'heading' => 'Quand cela fonctionne bien, et quand cela ne fonctionne pas',
                'body' => 'Les PDF qui ressemblent déjà à un tableau (factures, relevés bancaires, rapports exportés avec des colonnes claires) se convertissent bien, car leur texte s\'aligne nettement en lignes et colonnes. Le texte libre, comme des lettres ou des articles, n\'a pas de vraies colonnes à détecter, donc il finit souvent dans une seule colonne. Les cellules fusionnées, les cellules à plusieurs lignes et les pages scannées (image seule) ne sont pas prises en charge.',
            ],
            [
                'heading' => 'Pourquoi un PDF scanné ne se convertira pas',
                'body' => 'Un PDF scanné est une photographie d\'une page sans texte sélectionnable en dessous, donc il n\'y a rien que cet outil puisse lire. Convertir un scan nécessite d\'abord l\'OCR (reconnaissance optique de caractères), ce que cet outil ne fait pas ; si vous pouvez sélectionner et copier le texte dans votre lecteur de PDF, la conversion devrait fonctionner.',
            ],
        ],
        'faqs' => [
            ['q' => 'Les colonnes seront-elles parfaitement alignées ?', 'a' => 'Sur des PDF qui ressemblent déjà à un tableau, généralement oui. Sur du texte libre, il n\'y a pas de vraies colonnes à détecter, donc les résultats sont beaucoup moins fiables : c\'est toujours une extraction approximative, pas un lecteur de tableaux exact.'],
            ['q' => 'Puis-je convertir un PDF scanné ?', 'a' => 'Seulement s\'il contient déjà du texte sélectionnable. Une page scannée sans couche de texte n\'a rien que cet outil puisse extraire, puisqu\'il ne fait pas d\'OCR.'],
            ['q' => 'Comment les pages multiples sont-elles gérées ?', 'a' => 'Chaque page du PDF devient sa propre feuille dans le classeur, nommée « Page 1 », « Page 2 », et ainsi de suite.'],
            ['q' => 'Mon PDF est-il envoyé quelque part ?', 'a' => 'Non. Toute la conversion se fait dans votre navigateur avec JavaScript, et le fichier ne quitte jamais votre appareil.'],
        ],
    ],

    'html-to-pdf' => [
        'name' => 'HTML en PDF',
        'title' => 'Convertisseur HTML en PDF - Gratuit et Privé',
        'description' => 'Convertissez du HTML ou du texte brut en PDF en ligne gratuitement. Collez du code ou du texte et téléchargez un PDF avec titres, listes et mise en forme.',
        'h1' => 'Convertisseur HTML en PDF',
        'tagline' => 'Collez du HTML ou du texte brut et téléchargez-le en PDF.',
        'keywords' => [
            'html en pdf',
            'convertir html en pdf',
            'convertisseur html en pdf',
            'texte en pdf',
            'html en pdf gratuit',
        ],
        'intro' => 'Ce convertisseur HTML en PDF transforme du HTML collé, ou simplement du texte brut, en PDF téléchargeable. Il comprend les balises courantes comme les titres, paragraphes, retours à la ligne, listes, texte en gras et en italique, et images, et les met en page sur des pages A4 ou Lettre. Il ne va jamais chercher un autre site web : seul le HTML ou le texte que vous collez est utilisé, et le PDF est créé entièrement dans votre navigateur.',
        'steps' => [
            'Collez du HTML ou du texte brut dans la zone.',
            'Choisissez le format de page A4 ou Lettre.',
            'Cliquez sur Convertir en PDF et téléchargez le résultat.',
        ],
        'features' => [
            'Prend en charge les titres, paragraphes et retours à la ligne',
            'Prend en charge les listes à puces et numérotées',
            'Prend en charge le texte en gras et en italique',
            'Prend en charge les images données en URL de données',
            'Ne va jamais chercher d\'autres sites web : seul votre contenu collé est utilisé',
        ],
        'content' => [
            [
                'heading' => 'Quel HTML est pris en charge',
                'body' => 'Les titres (h1-h6), paragraphes, retours à la ligne, listes à puces et numérotées, texte en gras/strong et italique/em, et images données en URL de données sont mis en page dans le PDF. Les balises que cet outil ne comprend pas spécifiquement, comme les tableaux, les liens ou les styles personnalisés, sont ignorées, mais leur texte reste conservé pour que rien ne soit perdu silencieusement.',
            ],
            [
                'heading' => 'Pourquoi ne peut-il pas récupérer des images ou des pages depuis une URL ?',
                'body' => 'Cet outil ne fait jamais de requêtes réseau en votre nom, donc une balise <img src="https://..."> pointant vers un autre site web ne s\'affichera pas : seules les images déjà intégrées en URL de données sont affichées. Cela garde l\'outil privé et évite de contacter un site web sans votre action directe.',
            ],
        ],
        'faqs' => [
            ['q' => 'Puis-je convertir du texte brut, pas seulement du HTML ?', 'a' => 'Oui. Un texte sans aucune balise est traité comme un seul paragraphe, vous pouvez donc coller du texte brut directement.'],
            ['q' => 'Mon style CSS et mes couleurs seront-ils conservés ?', 'a' => 'Non. Cet outil se concentre sur la structure et le contenu lisible - titres, paragraphes, listes, gras/italique et images - plutôt que sur les couleurs, polices ou mise en page CSS exactes.'],
            ['q' => 'Peut-il convertir une page web depuis une URL ?', 'a' => 'Non, seulement du HTML ou du texte que vous collez vous-même. Il ne va jamais chercher d\'autres sites web, ce qui garde tout privé et prévisible.'],
            ['q' => 'Mon contenu collé est-il envoyé quelque part ?', 'a' => 'Non. Toute la conversion se fait dans votre navigateur avec JavaScript, et rien de ce que vous collez ne quitte jamais votre appareil.'],
        ],
    ],

    'sign-pdf' => [
        'name' => 'Signer un PDF',
        'title' => 'Signer un PDF en Ligne Gratuit - Votre Signature',
        'description' => 'Signez un PDF gratuitement. Dessinez, tapez ou importez votre signature et placez-la sur la page. Signature électronique, pas un certificat. Sans envoi.',
        'h1' => 'Signer un PDF',
        'tagline' => "Dessinez, tapez ou importez votre signature et placez-la sur n'importe quelle page, directement dans votre navigateur.",
        'keywords' => ['signer pdf', 'signer pdf en ligne', 'signature pdf', 'signature électronique pdf', 'ajouter une signature à un pdf'],
        'intro' => "Cet outil pour signer un PDF ajoute votre signature à un document sans imprimer, scanner ni rien installer. Dessinez-la avec la souris ou le doigt, tapez votre nom dans une police de signature, ou importez une photo de votre signature, puis faites-la glisser à l'endroit voulu sur n'importe quelle page et téléchargez le fichier signé. Il crée une signature électronique - une image placée sur la page - et non une signature numérique certifiée, et tout se passe sur votre appareil.",
        'steps' => [
            'Choisissez le PDF que vous voulez signer.',
            'Dessinez, tapez ou importez votre signature.',
            'Cliquez sur « Ajouter la signature à cette page », puis faites-la glisser ou redimensionnez-la.',
            'Changez de page pour ajouter de nouveau la signature si vous devez signer plusieurs pages.',
            'Cochez éventuellement « Ajouter la date du jour », puis cliquez sur Signer le PDF et téléchargez le fichier.',
        ],
        'features' => [
            'Dessinez avec la souris ou le doigt, tapez ou importez une image de signature',
            "Faites glisser et redimensionnez la signature sur n'importe quelle page",
            'Signez plusieurs pages dans un même PDF',
            'Date optionnelle ajoutée sous la signature',
            'Privé : votre PDF et votre signature ne quittent jamais votre appareil',
        ],
        'content' => [
            ['heading' => 'Quel type de signature est-ce ?', 'body' => "Cet outil crée une signature électronique : une image de votre signature dessinée, tapée ou importée, placée sur la page, comme vous signeriez à la main un formulaire imprimé. Ce n'est pas une signature numérique certifiée adossée à une clé publique et à une vérification d'identité, et aucune preuve cryptographique n'est ajoutée au fichier. Pour un accord courant, cela suffit généralement, mais vérifiez ce qu'exige un contrat ou une autorité précise avant de vous y fier pour quelque chose de juridiquement sensible."],
            ['heading' => 'Conseils pour une signature nette', 'body' => "Dessinez lentement et un peu plus grand que nécessaire : la signature peut être redimensionnée ensuite sans perdre en netteté. Si vous importez une photo de votre signature, utilisez un bon éclairage et un fond blanc uni, puis recadrez-la au plus près ; un PNG à fond transparent s'intègre le plus naturellement au contenu de la page."],
        ],
        'faqs' => [
            ['q' => 'Est-ce une signature numérique ayant une valeur légale ?', 'a' => "Cet outil crée une signature électronique - une image de signature placée sur le PDF - et non une signature numérique certifiée avec vérification d'identité. De nombreux accords courants acceptent les signatures électroniques, mais pour tout ce qui est juridiquement sensible, vérifiez d'abord ce qu'exige l'autre partie ou l'autorité concernée."],
            ['q' => 'Puis-je signer plusieurs pages ?', 'a' => 'Oui. Changez de page avec le navigateur de pages et cliquez à nouveau sur « Ajouter la signature à cette page » ; chaque signature placée peut être déplacée et redimensionnée indépendamment.'],
            ['q' => 'Mon PDF et ma signature sont-ils envoyés quelque part ?', 'a' => "Non. Le PDF est ouvert, signé et enregistré entièrement dans votre navigateur avec JavaScript, et rien n'est envoyé à un serveur."],
            ['q' => "Puis-je déplacer, redimensionner ou supprimer une signature après l'avoir placée ?", 'a' => 'Oui. Faites-la glisser pour la déplacer, tirez la poignée d\'angle pour la redimensionner, ou cliquez sur le bouton × pour la supprimer, tout cela avant de cliquer sur Signer le PDF.'],
            ['q' => "Quels formats d'image puis-je importer pour ma signature ?", 'a' => 'PNG, JPG et WebP. Un PNG à fond transparent donne généralement le meilleur résultat car il ne recouvre pas le contenu de la page avec un cadre blanc.'],
        ],
    ],

    'redact-pdf' => [
        'name' => 'Caviarder un PDF',
        'title' => 'Caviarder un PDF Gratuit - Supprimer du Texte',
        'description' => "Caviardez un PDF gratuitement en ligne. Dessinez des zones sur du texte ou des images pour les supprimer définitivement, pas juste les masquer.",
        'h1' => 'Caviarder un PDF',
        'tagline' => 'Dessinez une zone sur ce que vous devez masquer et supprimez-le pour de bon - directement dans votre navigateur.',
        'keywords' => ['caviarder pdf', 'caviarder pdf en ligne', 'masquer texte pdf', "supprimer du texte d'un pdf", 'outil de caviardage pdf'],
        'intro' => "Caviarder un PDF signifie supprimer définitivement du texte ou des images sensibles, pas seulement les recouvrir. Dessinez une zone sur ce que vous devez masquer - un nom, un numéro de compte, une photo - et cet outil reconstruit cette page sous forme d'image aplatie, afin que le contenu original en dessous disparaisse réellement et ne puisse être copié, recherché ou récupéré. Les pages que vous ne marquez pas conservent leur vrai texte, sélectionnable. Tout se passe dans votre navigateur ; le fichier n'est jamais envoyé.",
        'steps' => [
            'Choisissez le PDF que vous voulez caviarder.',
            'Dessinez une zone sur ce que vous voulez supprimer définitivement sur la page.',
            "Ajoutez d'autres zones sur cette page, ou changez de page pour en caviarder davantage.",
            'Cliquez sur Caviarder le PDF et téléchargez le fichier.',
        ],
        'features' => [
            "Dessinez des zones directement sur l'aperçu de la page",
            'Caviardage réel : les pages marquées sont aplaties en images',
            'Les pages sans zone conservent leur vrai texte, sélectionnable',
            'Déplacez, redimensionnez ou supprimez une zone avant de caviarder',
            'Privé : votre PDF ne quitte jamais votre appareil',
        ],
        'content' => [
            ['heading' => 'Pourquoi une simple zone noire ne suffit pas', 'body' => "Dessiner un simple rectangle noir sur un PDF dans de nombreux éditeurs ne fait que masquer le texte visuellement - le vrai texte reste présent dans le fichier en dessous et peut être copié, recherché ou extrait avec le bon outil. Cet outil transforme au contraire chaque page que vous marquez en une image aplatie, de sorte que le texte original et le contenu vectoriel de cette page soient entièrement supprimés, pas seulement cachés derrière une forme."],
            ['heading' => 'Ce qui change sur une page caviardée', 'body' => "Dès que vous caviardez au moins un endroit d'une page, toute la page devient une image : ce que vous voyez est exactement ce qui reste, mais aucun texte ne peut plus y être sélectionné, recherché ou copié, même en dehors des zones marquées. Les pages que vous ne marquez pas restent totalement intactes, avec leur vrai texte original et leur qualité."],
        ],
        'faqs' => [
            ['q' => 'Est-ce que cela supprime vraiment le texte, ou le cache-t-il juste sous une zone ?', 'a' => 'Il le supprime vraiment. Toute page comportant au moins une zone de caviardage est transformée en image, et cette image remplace la page, de sorte que le texte original et tout contenu sous ou autour de votre zone disparaissent du fichier - pas seulement recouverts.'],
            ['q' => 'Les pages sans zone de caviardage garderont-elles un texte sélectionnable ?', 'a' => "Oui. Seules les pages que vous marquez sont transformées en images ; toutes les autres conservent leur texte, leurs images et leur qualité d'origine, inchangés."],
            ['q' => 'Puis-je déplacer ou redimensionner une zone avant de caviarder ?', 'a' => "Oui. Faites-la glisser pour la déplacer, tirez sa poignée d'angle pour la redimensionner, ou cliquez sur le bouton × pour la supprimer, tout cela avant de cliquer sur Caviarder le PDF."],
            ['q' => 'Mon PDF est-il envoyé à un serveur ?', 'a' => "Non. Tout le processus de caviardage, y compris la transformation de la page en image, se déroule dans votre navigateur avec JavaScript, et rien n'est envoyé nulle part."],
            ['q' => "Pourquoi les pages caviardées paraissent-elles légèrement différentes de l'original ?", 'a' => "Comme ce sont désormais des images et non plus du texte et des graphiques vectoriels réels, un texte très fin ou des lignes fines peuvent paraître un peu moins nets en zoomant de près - le prix à payer pour garantir que rien en dessous ne puisse être récupéré."],
        ],
    ],

    'edit-pdf' => [
        'name' => 'Modifier un PDF',
        'title' => 'Modifier un PDF Gratuit - Ajouter du Texte',
        'description' => 'Modifiez un PDF en ligne gratuitement : changez le texte avec la police du PDF, ajoutez texte, images, formes, liens ou un filigrane, ou masquez du contenu.',
        'h1' => 'Modifier un PDF',
        'tagline' => 'Modifiez le texte déjà présent dans votre PDF ou ajoutez texte, images, formes et liens, directement dans le navigateur.',
        'keywords' => ['modifier pdf', 'modifier pdf en ligne', 'ajouter du texte à un pdf', 'annoter pdf', 'éditeur pdf gratuit'],
        'intro' => 'Cet éditeur PDF vous permet de modifier le texte déjà présent dans un PDF : cliquez sur une ligne, tapez la nouvelle formulation et elle est redessinée au même endroit, avec la police et la taille du PDF. Vous pouvez aussi ajouter du texte, des images, des surlignages, des formes, des flèches, des liens et des dessins à main levée, masquer en blanc ce que vous voulez faire disparaître, et rechercher et remplacer un mot sur toutes les pages. Tout se passe dans votre navigateur ; le fichier n’est jamais envoyé.',
        'steps' => [
            'Choisissez le PDF que vous voulez modifier.',
            'Choisissez Texte, Image, Surlignage ou Dessin et réglez sa taille ou sa couleur.',
            'Cliquez sur « Ajouter ... à la page », puis faites-le glisser, redimensionnez-le ou supprimez-le.',
            "Changez de page ou ajoutez d'autres éléments - Annuler supprime le dernier si vous changez d'avis.",
            'Cliquez sur Enregistrer le PDF et téléchargez le fichier.',
        ],
        'features' => [
            "Ajoutez du texte dans n'importe quelle taille et couleur",
            'Ajoutez vos propres images',
            "Surlignez n'importe quelle partie d'une page",
            'Dessinez à main levée avec la souris ou votre doigt',
            'Annulez ou rétablissez n\'importe quelle modification, ou supprimez n\'importe quel élément individuellement',
            'Masquage blanc pour couvrir du texte ou des images existants',
            'Formes : rectangle, ellipse, ligne et flèche',
            'Soulignement et texte barré',
            'Liens cliquables vers n’importe quel site',
            'Ajoutez un filigrane de texte ou de logo, au-dessus de la page ou derrière',
            'Zoomez ou dézoomez pour placer les éléments avec précision',
            'Faites pivoter le texte, les images, les surlignages et les formes à n’importe quel angle',
        ],
        'content' => [
            ['heading' => 'Comment fonctionne la modification du texte existant', 'body' => 'Cliquez sur une ligne de texte et tapez. L’ancienne formulation est recouverte de la couleur qui se trouve derrière, et la nouvelle est dessinée à la même position, dans la même taille et la même couleur, avec la police intégrée au PDF. Les PDF n’intègrent généralement que les lettres qu’ils utilisent : si votre nouveau texte demande une lettre que le fichier ne contenait pas, cette ligne passe à la police standard la plus proche et l’éditeur vous indique quelles lettres en sont la cause. Les pages numérisées sont des images sans texte modifiable ; utilisez-y le masquage blanc et Ajouter du texte.'],
            ['heading' => 'Bons usages pour ajouter du contenu à un PDF', 'body' => 'Corrigez une faute ou une date, mettez à jour un prix ou une adresse, ajoutez une note, un tampon, des initiales, un passage surligné ou une flèche qui pointe un détail : pratique pour corriger un document sans le fichier d’origine, relire un brouillon ou remplir un formulaire simple.'],
        ],
        'faqs' => [
            ['q' => 'Puis-je modifier le texte déjà présent dans le PDF ?', 'a' => 'Oui. Choisissez Modifier le texte, cliquez sur une ligne et tapez. La nouvelle formulation remplace l’ancienne au même endroit et, autant que possible, avec la police du PDF. Rechercher et remplacer change un mot sur toutes les pages à la fois. Le texte des pages numérisées fait partie d’une image et ne peut pas être modifié ainsi.'],
            ['q' => 'Puis-je annuler une erreur ?', 'a' => "Oui. Cliquez sur Annuler pour supprimer l'élément ajouté le plus récemment, ou cliquez sur le × de n'importe quel élément pour supprimer celui-là en particulier, le tout avant de cliquer sur Enregistrer le PDF."],
            ['q' => "Puis-je déplacer ou redimensionner ce que j'ai ajouté ?", 'a' => "Oui. Faites glisser n'importe quel texte, image ou surlignage pour le déplacer ; les images et les surlignages ont aussi une poignée d'angle pour les redimensionner. Les dessins à main levée peuvent aussi être déplacés."],
            ['q' => 'Mon PDF est-il envoyé à un serveur ?', 'a' => "Non. Tout - ajouter, déplacer, redimensionner et enregistrer - se passe dans votre navigateur avec JavaScript, et rien n'est envoyé nulle part."],
            ['q' => "Quels formats d'image puis-je ajouter ?", 'a' => 'PNG, JPG et WebP.'],
            ['q' => 'Puis-je ajouter un filigrane ?', 'a' => "Oui. Ouvrez l'onglet Filigrane pour tamponner du texte ou un logo sur la page, avec son opacité, sa rotation, sa position et ses pages propres - le même outil que celui de la page Filigrane PDF."],
        ],
    ],

    'watermark-pdf' => [
        'name' => 'Filigrane PDF',
        'title' => 'Filigrane PDF - Texte ou Logo Gratuit',
        'description' => "Ajoutez un filigrane de texte ou d'image à un PDF gratuitement en ligne. Choisissez la position, l'opacité, la rotation et les pages, avec un aperçu en direct.",
        'h1' => 'Filigrane PDF',
        'tagline' => 'Apposez un filigrane de texte ou de logo sur n\'importe quel PDF - privé, gratuit, sans inscription.',
        'keywords' => ['filigrane pdf', 'ajouter un filigrane à un pdf', 'filigrane pdf en ligne', 'filigrane texte pdf', 'filigrane image pdf'],
        'intro' => 'Mettre un filigrane sur un PDF consiste à apposer un texte (comme « CONFIDENTIEL » ou « BROUILLON ») ou le logo d\'une entreprise sur les pages, généralement avec une faible opacité, pour indiquer la propriété, le statut ou l\'état de brouillon du document. Tapez un ou deux mots, ou importez un logo en PNG ou JPG, puis réglez sa couleur ou sa taille, l\'opacité, la rotation et la position. Un aperçu en direct montre exactement à quoi ressemblera la première page avant de l\'appliquer à tout le document. Tout se passe dans votre navigateur, le PDF n\'est donc jamais envoyé.',
        'steps' => [
            'Choisissez le PDF auquel vous voulez ajouter un filigrane.',
            'Choisissez Texte ou Logo/Image et définissez son texte, sa couleur ou importez une image.',
            'Réglez l\'opacité, la rotation et la position (centre, un coin, ou en mosaïque sur toute la page).',
            'Vérifiez l\'aperçu en direct, puis choisissez les pages qui recevront le filigrane.',
            'Cliquez sur Ajouter un filigrane et téléchargez le résultat.',
        ],
        'features' => [
            'Filigrane de texte avec votre propre message, sa couleur, sa taille et le gras',
            'Filigrane d\'image ou de logo à partir d\'un fichier PNG ou JPG',
            'Opacité et rotation, diagonale par défaut',
            'Position : centre, n\'importe quel coin, ou en mosaïque sur toute la page',
            'Appliquez-le à toutes les pages, aux pages paires ou impaires, à une plage de pages, ou à toutes sauf la première',
            'Aperçu en direct de la première page avant de télécharger',
            'Derrière le contenu comme filigrane d’arrière-plan, ou au-dessus',
            'Aplatissement facultatif, pour que le filigrane ne puisse pas être supprimé',
        ],
        'content' => [
            ['heading' => 'Pourquoi ajouter un filigrane à un PDF ?', 'body' => 'Un filigrane indique qu\'un document est un brouillon, confidentiel, un échantillon ou la propriété d\'une personne ou d\'une entreprise avant d\'être partagé. Un tampon diagonal discret sur chaque page est difficile à manquer mais ne bloque pas le contenu en dessous, c\'est pourquoi une faible opacité et un angle incliné sont les réglages par défaut habituels.'],
            ['heading' => 'Filigrane de texte ou d\'image - lequel choisir ?', 'body' => 'Un mot ou une courte phrase (BROUILLON, CONFIDENTIEL, ÉCHANTILLON, le nom d\'une entreprise) fonctionne bien en texte, ne nécessite aucun fichier image et s\'accorde avec la typographie du reste du document s\'il reste simple. Une image de logo est préférable quand le filigrane doit afficher une marque précise - un PNG à fond transparent donne le résultat le plus net, car aucun cadre de couleur n\'apparaît autour.'],
        ],
        'faqs' => [
            ['q' => 'Puis-je régler la visibilité du filigrane ?', 'a' => 'Oui. Le curseur d\'opacité va de presque invisible à totalement opaque, et l\'aperçu en direct montre le résultat avant de télécharger.'],
            ['q' => 'Le filigrane est-il ajouté à toutes les pages ?', 'a' => 'Par défaut, oui. Vous pouvez aussi l\'appliquer seulement aux pages paires ou impaires, à toutes sauf la première, ou à une plage précise comme 1-3, 5.'],
            ['q' => 'Puis-je utiliser mon propre logo comme filigrane ?', 'a' => 'Oui. Importez une image PNG ou JPG et indiquez le pourcentage de la largeur de la page qu\'elle doit occuper. Un PNG transparent donne le meilleur résultat, car aucun cadre de fond n\'apparaît autour du logo.'],
            ['q' => 'Mon PDF est-il envoyé à un serveur ?', 'a' => 'Non. Le filigrane est dessiné entièrement dans votre navigateur avec JavaScript, et le PDF n\'est jamais envoyé nulle part.'],
            ['q' => 'Cet outil ajoute-t-il son propre filigrane ou logo ?', 'a' => 'Non. Le seul filigrane ajouté est le texte ou l\'image que vous choisissez vous-même ; l\'outil n\'appose jamais sa propre marque sur votre document.'],
        ],
    ],

    'mortgage-calculator' => [
        'name' => 'Calculateur de prêt immobilier',
        'title' => 'Calculateur de Prêt Immobilier - Mensualité et Amortissement',
        'description' => 'Calculateur de prêt immobilier gratuit : indiquez le prix, l\'apport, le taux et la durée pour voir la mensualité, les intérêts totaux et l\'amortissement.',
        'h1' => 'Calculateur de prêt immobilier',
        'tagline' => 'Consultez votre mensualité, vos intérêts totaux et le tableau d\'amortissement année par année.',
        'keywords' => [
            'calculateur de prêt immobilier',
            'calculateur de mensualité de prêt',
            'simulateur de crédit immobilier',
            'calculateur d\'amortissement',
            'calculateur de prêt immobilier avec remboursement anticipé',
        ],
        'intro' => 'Un calculateur de prêt immobilier détermine la mensualité de capital et d\'intérêts d\'un crédit immobilier à partir du prix du bien, de l\'apport personnel, du taux d\'intérêt et de la durée du prêt. Saisissez vos chiffres ci-dessous pour voir la mensualité, le total des intérêts payés sur toute la durée du prêt, et un tableau d\'amortissement complet, année par année, montrant la part de chaque mensualité qui va au capital et celle qui va aux intérêts. Un paiement mensuel supplémentaire facultatif montre de combien le prêt est remboursé plus tôt et combien d\'intérêts cela permet d\'économiser.',
        'steps' => [
            'Indiquez le prix du bien et choisissez une devise.',
            'Définissez l\'apport personnel, en pourcentage ou en montant fixe.',
            'Indiquez le taux d\'intérêt annuel et choisissez une durée (10 à 30 ans, ou saisissez une durée personnalisée).',
            'Indiquez éventuellement un paiement mensuel supplémentaire pour voir de combien le prêt est remboursé plus tôt.',
            'Consultez la mensualité, les intérêts et le coût total, puis ouvrez le tableau d\'amortissement pour le détail année par année.',
        ],
        'features' => [
            'Mensualité de capital et d\'intérêts, intérêts totaux et coût total',
            'Apport personnel en pourcentage ou en montant fixe',
            'Tableau d\'amortissement complet, année par année',
            'Les paiements supplémentaires montrent le temps et les intérêts économisés',
            'Fonctionne avec n\'importe quelle devise et une durée de prêt de 1 à 50 ans',
            'Fonctionne entièrement dans votre navigateur - rien de ce que vous saisissez n\'est envoyé où que ce soit',
        ],
        'content' => [
            [
                'heading' => 'Comment la mensualité est-elle calculée ?',
                'body' => 'Le calculateur utilise la formule d\'amortissement standard à taux fixe : M = P x r / (1 - (1 + r)^-n), où P est le montant du prêt (prix du bien moins l\'apport personnel), r est le taux d\'intérêt mensuel (le taux annuel divisé par 12) et n est le nombre total de mensualités (la durée du prêt en années multipliée par 12). C\'est la même formule utilisée par les banques pour un prêt à taux fixe, et elle ne couvre que le capital et les intérêts - la taxe foncière, l\'assurance habitation, l\'assurance prêt (PMI) et les charges de copropriété ne sont pas incluses, car elles varient selon le lieu et le prêteur.',
            ],
            [
                'heading' => 'Pourquoi les paiements supplémentaires économisent-ils autant d\'intérêts ?',
                'body' => 'Chaque euro supplémentaire versé sur le capital cesse de générer des intérêts pour le reste du prêt, donc payer en plus tôt dans la vie du prêt - quand le solde et la part d\'intérêts de chaque mensualité sont les plus élevés - a le plus grand effet. Le calculateur compare le tableau d\'amortissement avec et sans le paiement supplémentaire pour montrer exactement de combien de mois le prêt est remboursé plus tôt et combien d\'intérêts totaux sont évités.',
            ],
            [
                'heading' => 'L\'apport personnel est-il le même que le "deposit" au Royaume-Uni ?',
                'body' => 'La somme versée au départ pour un bien, qui réduit le prêt nécessaire, s\'appelle "down payment" aux États-Unis et "deposit" au Royaume-Uni, en Irlande et dans plusieurs autres pays - les deux désignent ici la même chose que l\'apport personnel. Un apport plus important signifie un prêt plus petit, une mensualité plus basse et moins d\'intérêts payés au total, même si les prêteurs peuvent aussi avoir leur propre apport minimum et d\'autres critères d\'éligibilité que ce calculateur ne couvre pas.',
            ],
        ],
        'faqs' => [
            ['q' => 'Que couvre cette mensualité de prêt immobilier ?', 'a' => 'Seulement le capital et les intérêts. La taxe foncière, l\'assurance habitation, l\'assurance prêt (PMI) et les charges de copropriété ne sont pas incluses car elles varient selon le lieu, le prêteur et l\'assureur.'],
            ['q' => 'En quoi un paiement mensuel supplémentaire aide-t-il ?', 'a' => 'L\'argent supplémentaire va directement au capital du prêt, qui cesse donc de générer des intérêts pour le reste du prêt. Le calculateur montre exactement de combien de mois le prêt est remboursé plus tôt et combien d\'intérêts totaux sont économisés.'],
            ['q' => 'Quelle est une durée de prêt immobilier typique ?', 'a' => '30 ans est le plus courant aux États-Unis ; 25 ans est plus habituel au Royaume-Uni et en Irlande. Des durées plus courtes (10 à 20 ans) signifient une mensualité plus élevée mais beaucoup moins d\'intérêts au total.'],
            ['q' => 'L\'apport personnel est-il la même chose que le "deposit" ?', 'a' => 'Oui - "down payment" est le terme américain et "deposit" est le terme utilisé au Royaume-Uni et en Irlande pour désigner la même somme versée au départ pour un bien.'],
            ['q' => 'Pourquoi l\'offre de ma banque diffère-t-elle de ce calculateur ?', 'a' => 'Les prêteurs ajoutent la taxe foncière, l\'assurance, le PMI, des frais et leurs propres arrondis, et votre taux réel dépend de votre profil de crédit, de votre prêteur et du type de prêt. Ce calculateur montre le calcul de capital et d\'intérêts sous-jacent pour comparer rapidement des scénarios.'],
        ],
        'table' => [
            'caption' => 'Mensualité et intérêts totaux d\'un prêt de $300,000 à 6,5 % selon la durée (capital et intérêts uniquement)',
            'headers' => ['Durée du prêt', 'Mensualité', 'Intérêts totaux payés'],
            'rows' => [
                ['15 ans', '$2,613.32', '$170,397.98'],
                ['20 ans', '$2,236.72', '$236,812.66'],
                ['25 ans', '$2,025.62', '$307,686.45'],
                ['30 ans', '$1,896.20', '$382,633.47'],
            ],
        ],
    ],

    'loan-calculator' => [
        'name' => 'Calculateur de prêt',
        'title' => 'Calculateur de Prêt - Mensualité et Amortissement',
        'description' => 'Calculateur de prêt gratuit : saisissez le montant, le taux d\'intérêt et la durée pour voir la mensualité, les intérêts et le tableau.',
        'h1' => 'Calculateur de prêt',
        'tagline' => 'Consultez la mensualité, les intérêts totaux et un tableau d\'amortissement année par année pour n\'importe quel prêt à taux fixe.',
        'keywords' => [
            'calculateur de prêt',
            'calculateur de mensualité de prêt',
            'calculateur de prêt personnel',
            'calculateur de crédit auto',
            'calculateur d\'amortissement',
        ],
        'intro' => 'Un calculateur de prêt détermine la mensualité fixe d\'un prêt à partir du montant emprunté, du taux d\'intérêt et de la durée. Saisissez vos chiffres ci-dessous pour voir la mensualité, le total des intérêts payés sur toute la durée du prêt, et un tableau d\'amortissement complet, année par année, montrant la part de chaque mensualité qui va au capital et celle qui va aux intérêts. Il fonctionne pour un prêt personnel, un crédit auto, un prêt étudiant ou tout autre prêt à taux fixe et durée fixe - un paiement mensuel supplémentaire facultatif montre de combien il est remboursé plus tôt et combien d\'intérêts cela permet d\'économiser.',
        'steps' => [
            'Indiquez le montant du prêt et choisissez une devise.',
            'Indiquez le taux d\'intérêt annuel et choisissez une durée (2 à 10 ans, ou saisissez une durée personnalisée).',
            'Indiquez éventuellement un paiement mensuel supplémentaire pour voir de combien le prêt est remboursé plus tôt.',
            'Consultez la mensualité, les intérêts totaux et le remboursement total, puis ouvrez le tableau d\'amortissement pour le détail année par année.',
        ],
        'features' => [
            'Mensualité, intérêts totaux et remboursement total',
            'Fonctionne pour un prêt personnel, un crédit auto, un prêt étudiant ou tout autre prêt à taux fixe',
            'Tableau d\'amortissement complet, année par année',
            'Les paiements supplémentaires montrent le temps et les intérêts économisés',
            'Fonctionne avec n\'importe quelle devise et une durée de 1 à 50 ans',
            'Fonctionne entièrement dans votre navigateur - rien de ce que vous saisissez n\'est envoyé où que ce soit',
        ],
        'content' => [
            [
                'heading' => 'Comment la mensualité est-elle calculée ?',
                'body' => 'Le calculateur utilise la formule d\'amortissement standard à taux fixe : M = P x r / (1 - (1 + r)^-n), où P est le montant du prêt, r est le taux d\'intérêt mensuel (le taux annuel divisé par 12) et n est le nombre total de mensualités (la durée en années multipliée par 12). C\'est la même formule utilisée par les prêteurs pour un prêt à taux fixe et durée fixe - personnel, auto, étudiant ou autre - et elle ne couvre que le capital et les intérêts : les frais du prêteur, frais de dossier ou assurances ne sont pas inclus, car ils varient selon le prêteur et le type de prêt.',
            ],
            [
                'heading' => 'Pourquoi les paiements supplémentaires économisent-ils autant d\'intérêts ?',
                'body' => 'Chaque euro supplémentaire versé sur le capital cesse de générer des intérêts pour le reste du prêt, donc payer en plus tôt dans la vie du prêt - quand le solde et la part d\'intérêts de chaque mensualité sont les plus élevés - a le plus grand effet. Le calculateur compare le tableau d\'amortissement avec et sans le paiement supplémentaire pour montrer exactement de combien de mois le prêt est remboursé plus tôt et combien d\'intérêts totaux sont évités. Vérifiez d\'abord votre contrat : certains prêteurs appliquent des pénalités de remboursement anticipé.',
            ],
        ],
        'faqs' => [
            ['q' => 'Que couvre cette mensualité de prêt ?', 'a' => 'Seulement le capital et les intérêts. Les frais du prêteur, frais de dossier et assurances ne sont pas inclus car ils varient selon le prêteur et le type de prêt.'],
            ['q' => 'Puis-je l\'utiliser pour un crédit auto ou un prêt personnel, pas seulement un prêt immobilier ?', 'a' => 'Oui. Le calcul est le même pour tout prêt à taux fixe et durée fixe - personnel, auto, étudiant ou autre. Pour un prêt immobilier avec apport personnel, utilisez plutôt le Calculateur de prêt immobilier.'],
            ['q' => 'En quoi un paiement mensuel supplémentaire aide-t-il ?', 'a' => 'L\'argent supplémentaire va directement au capital du prêt, qui cesse donc de générer des intérêts pour le reste du prêt. Le calculateur montre exactement de combien de mois il est remboursé plus tôt et combien d\'intérêts totaux sont économisés.'],
            ['q' => 'Pourquoi l\'offre de mon prêteur diffère-t-elle de ce calculateur ?', 'a' => 'Les prêteurs ajoutent des frais, une assurance et leurs propres arrondis, et votre taux réel dépend de votre profil de crédit, de votre prêteur et du type de prêt. Ce calculateur montre le calcul de capital et d\'intérêts sous-jacent pour comparer rapidement des offres.'],
            ['q' => 'Y a-t-il une pénalité pour remboursement anticipé d\'un prêt ?', 'a' => 'Cela dépend du prêteur et du contrat - certains prêts à taux fixe appliquent une pénalité de remboursement anticipé. Vérifiez votre contrat avant de faire des paiements supplémentaires.'],
        ],
        'table' => [
            'caption' => 'Mensualité et intérêts totaux d\'un prêt de 20 000 $ à 7 % selon la durée (capital et intérêts seulement)',
            'headers' => ['Durée', 'Mensualité', 'Intérêts totaux payés'],
            'rows' => [
                ['2 ans', '$895.45', '$1,490.84'],
                ['3 ans', '$617.54', '$2,231.51'],
                ['5 ans', '$396.02', '$3,761.44'],
                ['7 ans', '$301.85', '$5,355.70'],
            ],
        ],
    ],

    'compound-interest-calculator' => [
        'name' => 'Calculateur d\'intérêts composés',
        'title' => 'Calculateur d\'Intérêts Composés - Graphique et Tableau',
        'description' => 'Calculateur d\'intérêts composés gratuit. Découvrez comment un montant initial et des versements mensuels évoluent, avec graphique et tableau.',
        'h1' => 'Calculateur d\'intérêts composés',
        'tagline' => 'Découvrez comment un montant initial et des versements mensuels évoluent avec le temps, avec un graphique et un tableau année par année.',
        'keywords' => [
            'calculateur d\'intérêts composés',
            'calculateur d\'intérêts composés avec versements mensuels',
            'calculateur de croissance d\'investissement',
            'calculateur d\'intérêts',
            'calculateur d\'intérêts composés quotidiens',
        ],
        'intro' => 'Les intérêts composés sont des intérêts gagnés à la fois sur votre argent initial et sur les intérêts qu\'il a déjà générés, si bien qu\'un solde croît plus vite plus longtemps il est laissé à capitaliser. Indiquez un montant initial, un taux d\'intérêt annuel, le nombre d\'années de croissance et la fréquence de capitalisation, et ajoutez éventuellement un versement mensuel. Le calculateur affiche le solde final, le total versé, les intérêts totaux gagnés, un graphique de croissance et un tableau année par année.',
        'steps' => [
            'Indiquez un montant initial et choisissez une devise.',
            'Indiquez le taux d\'intérêt annuel, le nombre d\'années et la fréquence de capitalisation (annuelle, semestrielle, trimestrielle, mensuelle ou quotidienne).',
            'Indiquez éventuellement un versement mensuel pour voir comment des dépôts réguliers s\'ajoutent à la croissance.',
            'Consultez le solde final, le total versé et les intérêts totaux gagnés, puis ouvrez le tableau année par année pour le détail complet.',
        ],
        'features' => [
            'Solde final, total versé et intérêts totaux gagnés',
            'Graphique de croissance montrant les versements par rapport aux intérêts gagnés',
            'N\'importe quelle fréquence de capitalisation : annuelle, semestrielle, trimestrielle, mensuelle ou quotidienne',
            'Versements mensuels facultatifs en plus d\'un montant initial',
            'Tableau complet du solde année par année',
            'Fonctionne entièrement dans votre navigateur - rien de ce que vous saisissez n\'est envoyé où que ce soit',
        ],
        'content' => [
            [
                'heading' => 'Comment les intérêts composés sont-ils calculés ?',
                'body' => 'Chaque fois que les intérêts se capitalisent, ils s\'ajoutent au solde, et le tour suivant d\'intérêts est calculé sur ce montant plus élevé, pas seulement sur l\'argent initial. Plus les intérêts se capitalisent souvent (quotidiennement plutôt qu\'annuellement, par exemple) et plus l\'argent est laissé à croître longtemps, plus l\'effet est important, car chaque période de capitalisation contient un peu plus d\'« intérêts sur intérêts » que la précédente.',
            ],
            [
                'heading' => 'Pourquoi les versements mensuels font-ils une telle différence ?',
                'body' => 'Chaque versement que vous ajoutez commence à se capitaliser dès le jour où il est effectué, donc l\'argent versé en début de période a bien plus de temps pour croître que celui versé en fin de période. Sur de nombreuses années, des versements mensuels réguliers peuvent représenter une part du solde final plus importante que le montant initial lui-même.',
            ],
        ],
        'faqs' => [
            ['q' => 'Quelle fréquence de capitalisation dois-je choisir ?', 'a' => 'Utilisez celle indiquée par votre banque, obligation ou compte d\'investissement - les comptes d\'épargne se capitalisent souvent quotidiennement ou mensuellement, tandis que certaines obligations se capitalisent semestriellement ou annuellement. En cas de doute, mensuelle est un choix courant, et la différence entre les fréquences est généralement faible comparée au taux d\'intérêt lui-même.'],
            ['q' => 'Est-ce un rendement garanti ?', 'a' => 'Non. Ce calculateur projette la croissance à un taux d\'intérêt fixe que vous choisissez. Les rendements réels de l\'épargne et des investissements varient d\'une année à l\'autre, et les investissements peuvent perdre de la valeur, alors considérez le résultat comme une estimation, pas une promesse.'],
            ['q' => 'Cela tient-il compte des impôts ou de l\'inflation ?', 'a' => 'Non. Le résultat est la croissance brute de votre argent avant tout impôt sur les intérêts ou les gains d\'investissement, et sans ajustement pour l\'inflation. Votre pouvoir d\'achat réel dans le futur sera inférieur au solde brut affiché ici.'],
            ['q' => 'Quelle est la différence entre ceci et le Calculateur de prêt ?', 'a' => 'Cet outil fait croître un solde avec les intérêts travaillant en votre faveur (épargne et investissements). Le Calculateur de prêt montre un solde qui diminue avec le temps, avec les intérêts travaillant contre vous (prêts et hypothèques).'],
            ['q' => 'Puis-je l\'utiliser pour l\'épargne retraite ?', 'a' => 'Oui, il fonctionne pour n\'importe quel montant unique associé à des versements réguliers - un compte d\'épargne, un compte d\'investissement ou un compte retraite. Utilisez simplement un rendement annuel estimé réaliste et rappelez-vous qu\'il s\'agit d\'une projection, pas d\'une garantie.'],
        ],
        'table' => [
            'caption' => 'Comment 10 000 $ évoluent à 6 % d\'intérêt annuel, capitalisés mensuellement, sans versement supplémentaire',
            'headers' => ['Années', 'Solde', 'Intérêts gagnés'],
            'rows' => [
                ['5 ans', '$13,488.50', '$3,488.50'],
                ['10 ans', '$18,193.97', '$8,193.97'],
                ['20 ans', '$33,102.04', '$23,102.04'],
                ['30 ans', '$60,225.75', '$50,225.75'],
            ],
        ],
    ],
];
