<?php

return [

    'word-counter' => [
        'name' => 'Compteur de mots',
        'title' => 'Compteur de mots : compter mots et caractères gratuitement',
        'description' => 'Compteur de mots gratuit : comptez mots, caractères, phrases et paragraphes en direct, avec temps de lecture et mots-clés. Sans inscription.',
        'h1' => 'Compteur de mots',
        'tagline' => 'Comptez les mots, les caractères, les phrases et le temps de lecture instantanément.',
        'keywords' => ['compteur de mots', 'compteur de caractères', 'nombre de mots', 'compter les mots en ligne', 'calcul du temps de lecture'],
        'intro' => 'Collez ou saisissez votre texte ci-dessous pour compter les mots, caractères, phrases et paragraphes au fil de la frappe. Le compteur affiche aussi le temps de lecture et de parole estimé ainsi que vos mots-clés les plus utilisés, pratique pour les dissertations, articles de blog, légendes de réseaux sociaux et méta-descriptions SEO.',
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
                'heading' => 'Pourquoi le nombre de mots compte',
                'body' => 'Écoles, universités et éditeurs imposent souvent des limites de mots strictes, et les réseaux sociaux plafonnent le nombre de caractères par publication. Les moteurs de recherche affichent en général environ 155-160 caractères d’une méta-description, et une balise title devrait rester sous 60 caractères environ. Connaître votre nombre exact vous aide à atteindre ces objectifs sans deviner.',
            ],
            [
                'heading' => 'Comment les mots sont comptés',
                'body' => 'Un mot est un groupe de lettres ou de chiffres séparé par des espaces ou des retours à la ligne. La ponctuation seule ne compte pas comme un mot. Les phrases sont comptées grâce à la ponctuation finale (. ! ?) et les paragraphes grâce aux lignes vides : les chiffres correspondent donc à ceux de traitements de texte comme Microsoft Word et Google Docs.',
            ],
        ],
        'faqs' => [
            ['q' => 'Ce compteur de mots est-il gratuit ?', 'a' => 'Oui. Le compteur de mots est entièrement gratuit, sans inscription et sans limite sur la quantité de texte collé.'],
            ['q' => 'Mon texte est-il enregistré ou envoyé ?', 'a' => 'Non. Le comptage se fait entièrement dans votre navigateur. Votre texte n’est jamais envoyé à notre serveur ni stocké nulle part.'],
            ['q' => 'Comment le temps de lecture est-il calculé ?', 'a' => 'Le temps de lecture se base sur une vitesse moyenne de lecture silencieuse de 238 mots par minute chez l’adulte. Le temps de parole utilise 150 mots par minute, un rythme typique pour une présentation.'],
            ['q' => 'Combien de mots fait une dissertation de 5 pages ?', 'a' => 'Avec un interligne double et une police de 12 points, une page compte environ 250 à 300 mots : une dissertation de 5 pages fait donc environ 1 250 à 1 500 mots.'],
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
        'intro' => 'Vous avez tapé avec la touche Verr. Maj activée ou il vous faut un titre avec des majuscules ? Collez votre texte et cliquez sur un bouton pour le convertir instantanément. Les développeurs peuvent aussi basculer entre camelCase, PascalCase, snake_case, kebab-case et CONSTANT_CASE.',
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
                'heading' => 'Casse Titre ou casse Phrase',
                'body' => 'La casse Titre met une majuscule aux mots principaux d’un titre (« Le Guide Rapide du SEO »), tandis que les petits mots comme le, et, de et du restent en minuscules sauf en début de titre. La casse Phrase ne met une majuscule qu’au premier mot de chaque phrase (« Le guide rapide du SEO »), ce que préfèrent de nombreux sites modernes pour la lisibilité. En français, c’est d’ailleurs la norme typographique.',
            ],
            [
                'heading' => 'Casses utilisées en programmation',
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
        'intro' => 'Créez un mot de passe fort et aléatoire, presque impossible à deviner. Choisissez la longueur et les caractères à inclure : le générateur utilise le générateur de nombres aléatoires cryptographiquement sûr de votre navigateur. Les mots de passe ne sont jamais envoyés à notre serveur.',
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
                'heading' => 'Conseils de sécurité',
                'body' => 'Utilisez un mot de passe différent pour chaque compte, conservez-les dans un gestionnaire de mots de passe et activez la double authentification partout où c’est possible. Ne réutilisez jamais un mot de passe apparu dans une fuite de données.',
            ],
        ],
        'faqs' => [
            ['q' => 'Ce générateur de mots de passe est-il sûr ?', 'a' => 'Oui. Les mots de passe sont générés dans votre navigateur avec la Web Crypto API. Rien n’est envoyé à notre serveur, journalisé ou stocké.'],
            ['q' => 'Quelle longueur choisir ?', 'a' => 'Au moins 12 caractères, et 16 ou plus pour les comptes importants comme la messagerie et la banque.'],
            ['q' => 'À quoi sert « exclure les caractères similaires » ?', 'a' => 'Cette option retire les caractères qui se ressemblent, comme l, 1, I, O et 0, pour que le mot de passe soit plus facile à lire et à saisir à la main.'],
            ['q' => 'Qu’est-ce que l’entropie d’un mot de passe ?', 'a' => 'L’entropie mesure en bits à quel point un mot de passe est imprévisible. Chaque bit supplémentaire double le nombre d’essais nécessaires à un attaquant. 80 bits et plus, c’est fort ; 100 bits et plus, c’est excellent.'],
        ],
    ],

    'qr-code-generator' => [
        'name' => 'Générateur de QR code',
        'title' => 'Générateur de QR code gratuit pour URL, Wi-Fi et plus',
        'description' => 'Créez des QR codes gratuits pour liens, texte, Wi-Fi, e-mail, téléphone et SMS. Couleurs et tailles au choix, PNG ou SVG, sans expiration.',
        'h1' => 'Générateur de QR code gratuit',
        'tagline' => 'Créez des QR codes pour liens, Wi-Fi, e-mail, téléphone et SMS. Téléchargez en PNG ou SVG.',
        'keywords' => ['générateur de qr code', 'qr code gratuit', 'qr code wifi', 'créer un qr code', 'qr code pour url'],
        'intro' => 'Créez en quelques secondes un QR code pour un lien, un texte, un réseau Wi-Fi, un e-mail, un numéro de téléphone ou un SMS. Choisissez les couleurs et la taille, puis téléchargez un PNG de haute qualité pour l’écran ou un SVG pour l’impression. Ce sont des QR codes statiques : ils fonctionnent pour toujours et n’expirent jamais.',
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
                'heading' => 'Comment créer un QR code Wi-Fi',
                'body' => 'Choisissez le type Wi-Fi et saisissez le nom du réseau (SSID), le mot de passe et le type de sécurité. Vos invités n’ont plus qu’à scanner le code avec l’appareil photo de leur téléphone pour se connecter sans taper le mot de passe : idéal pour la maison, les cafés et les bureaux.',
            ],
            [
                'heading' => 'Conseils pour des QR codes toujours lisibles',
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
    ],

    'image-compressor' => [
        'name' => 'Compresseur d’images',
        'title' => 'Compresseur d’images : compresser JPG, PNG et WebP en ligne',
        'description' => 'Compressez des images JPG, PNG et WebP gratuitement. Réduisez une photo à 100 Ko sans perte visible. Rien ne quitte votre appareil.',
        'h1' => 'Compresseur d’images',
        'tagline' => 'Réduisez le poids des fichiers JPG, PNG et WebP, même à une taille précise comme 100 Ko.',
        'keywords' => ['compresseur d’image', 'compresser une image', 'compresser une image à 100 ko', 'réduire la taille d’une image', 'compresser jpg'],
        'intro' => 'Allégez vos images sans perte de qualité visible. Déposez un ou plusieurs fichiers JPG, PNG ou WebP, choisissez un niveau de qualité ou une taille cible comme 100 Ko, puis téléchargez les images compressées. La compression se fait dans votre navigateur : vos photos ne sont jamais envoyées.',
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
            ['q' => 'Pourquoi mon PNG a-t-il à peine diminué ?', 'a' => 'Le PNG est un format sans perte. Pour un gain important, choisissez WebP ou JPG comme format de sortie. Prenez WebP si vous devez conserver la transparence.'],
            ['q' => 'Y a-t-il une limite de taille ?', 'a' => 'Chaque image peut peser jusqu’à 50 Mo. Les très grandes photos peuvent prendre quelques secondes sur les téléphones anciens.'],
        ],
    ],

    'image-resizer' => [
        'name' => 'Redimensionner une image',
        'title' => 'Redimensionner une image : JPG, PNG, WebP gratuit',
        'description' => 'Redimensionnez une image au pixel près ou en pourcentage et convertissez JPG, PNG et WebP. Gratuit, en ligne et sans envoyer vos photos.',
        'h1' => 'Redimensionner et convertir une image',
        'tagline' => 'Redimensionnez au pixel près ou en pourcentage, et convertissez JPG, PNG et WebP.',
        'keywords' => ['redimensionner une image', 'changer la taille d’une image', 'png en jpg', 'jpg en png', 'webp en jpg', 'convertisseur d’image'],
        'intro' => 'Redimensionnez une photo aux dimensions exactes d’un réseau social, d’un formulaire de passeport ou de votre site, ou changez son échelle en pourcentage. Vous pouvez aussi convertir le format, par exemple PNG en JPG ou WebP en PNG. Tout se passe dans votre navigateur.',
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
                'heading' => 'Tailles d’image courantes',
                'body' => 'Les publications Instagram rendent bien en 1080 x 1080 pixels, les images partagées sur Facebook et LinkedIn en 1200 x 630, les miniatures YouTube en 1280 x 720, et les grandes images de sites web ne dépassent généralement pas 1920 pixels de large.',
            ],
            [
                'heading' => 'Convertir un PNG en JPG',
                'body' => 'Le JPG ne gère pas la transparence : les zones transparentes deviennent blanches quand vous convertissez un PNG en JPG. Pour conserver la transparence, choisissez PNG ou WebP comme format de sortie.',
            ],
        ],
        'faqs' => [
            ['q' => 'Comment redimensionner une image sans la déformer ?', 'a' => 'Laissez « Conserver les proportions » coché. Quand vous changez la largeur, la hauteur s’ajuste automatiquement pour garder les proportions d’origine.'],
            ['q' => 'Puis-je convertir un WebP en JPG ?', 'a' => 'Oui. Ouvrez votre image WebP, choisissez JPG comme format de sortie et téléchargez.'],
            ['q' => 'Redimensionner réduit-il la qualité ?', 'a' => 'Réduire une image la garde nette. L’agrandir beaucoup au-delà de l’original peut la rendre floue, car aucun nouveau détail ne peut être créé.'],
            ['q' => 'Quelle est la taille maximale ?', 'a' => 'Les images de sortie peuvent atteindre 10 000 pixels de côté, ce que tous les navigateurs modernes savent gérer.'],
        ],
    ],

    'merge-pdf' => [
        'name' => 'Fusionner des PDF',
        'title' => 'Fusionner PDF : combiner des fichiers PDF gratuitement',
        'description' => 'Fusionnez des fichiers PDF en un seul document, gratuitement. Réorganisez l’ordre, sans filigrane ni inscription. Rien n’est envoyé.',
        'h1' => 'Fusionner des fichiers PDF',
        'tagline' => 'Combinez plusieurs PDF en un seul fichier, sans filigrane et sans envoi.',
        'keywords' => ['fusionner pdf', 'combiner pdf', 'assembler des pdf', 'fusion pdf', 'fusionner pdf en ligne gratuit'],
        'intro' => 'Combinez plusieurs fichiers PDF en un seul document, dans l’ordre de votre choix. Contrairement à beaucoup de sites PDF, vos fichiers sont fusionnés dans votre navigateur : les documents confidentiels ne passent jamais par un serveur, et le résultat n’a pas de filigrane.',
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
                'heading' => 'PDF protégés par mot de passe',
                'body' => 'Les PDF chiffrés ne peuvent pas être fusionnés tant que la protection n’est pas retirée. Ouvrez le fichier dans votre lecteur PDF avec le mot de passe, enregistrez ou imprimez une copie sans protection, puis fusionnez cette copie.',
            ],
        ],
        'faqs' => [
            ['q' => 'Est-il sûr de fusionner des PDF ici ?', 'a' => 'Oui. Les fichiers sont traités localement dans votre navigateur avec JavaScript et ne sont jamais envoyés : ils restent totalement privés.'],
            ['q' => 'Y a-t-il un filigrane ?', 'a' => 'Non. Le PDF fusionné n’a ni filigrane, ni logo, ni pages ajoutées.'],
            ['q' => 'Combien de PDF puis-je fusionner ?', 'a' => 'Jusqu’à 50 fichiers à la fois. La limite pratique dépend de la mémoire de votre appareil, et la plupart gèrent facilement quelques centaines de pages.'],
            ['q' => 'Les liens et signets sont-ils conservés ?', 'a' => 'Le contenu des pages, les images et le texte sont conservés à l’identique. Certaines fonctions interactives, comme les signets et les champs de formulaire, peuvent ne pas être reprises.'],
        ],
    ],

    'split-pdf' => [
        'name' => 'Diviser un PDF',
        'title' => 'Diviser PDF : extraire des pages d’un PDF gratuitement',
        'description' => 'Divisez un PDF en plusieurs fichiers ou extrayez des pages en ligne. Choisissez des plages comme 1-3, 5. Gratuit, sans envoi ni filigrane.',
        'h1' => 'Diviser un PDF et extraire des pages',
        'tagline' => 'Extrayez des pages ou divisez un PDF en fichiers séparés, en toute confidentialité dans votre navigateur.',
        'keywords' => ['diviser pdf', 'extraire des pages pdf', 'séparer les pages d’un pdf', 'découper un pdf', 'diviser pdf en ligne'],
        'intro' => 'Récupérez uniquement les pages dont vous avez besoin dans un PDF, ou divisez-le en plusieurs fichiers. Saisissez des plages comme 1-3, 5, 8-10, ou séparez chaque page dans son propre PDF. Tout le traitement se fait dans votre navigateur.',
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
        'title' => 'Calcul d’âge : âge exact depuis la date de naissance',
        'description' => 'Calculez votre âge exact en années, mois et jours depuis votre date de naissance, avec les jours vécus et le compte à rebours d’anniversaire.',
        'h1' => 'Calculateur d’âge',
        'tagline' => 'Trouvez votre âge exact en années, mois et jours, et votre prochain anniversaire.',
        'keywords' => ['calculateur d’âge', 'calculer son âge', 'calcul date de naissance', 'quel âge ai-je', 'calcul âge avec date de naissance'],
        'intro' => 'Saisissez une date de naissance pour connaître l’âge exact en années, mois et jours. Vous obtenez aussi le nombre total de mois, semaines, jours et heures vécus, le jour de la semaine de votre naissance et un compte à rebours jusqu’à votre prochain anniversaire. Vous pouvez aussi calculer un âge à n’importe quelle date passée ou future.',
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
        ],
    ],

    'percentage-calculator' => [
        'name' => 'Calculateur de pourcentage',
        'title' => 'Calcul de pourcentage : pourcentage, variation, hausse',
        'description' => 'Calcul de pourcentage gratuit : X % de Y, quel pourcentage X représente de Y, hausse ou baisse en pourcentage et plus. Formule affichée.',
        'h1' => 'Calculateur de pourcentage',
        'tagline' => 'Tous les calculs de pourcentage courants au même endroit, avec la formule.',
        'keywords' => ['calcul pourcentage', 'calculateur de pourcentage', 'calcul de variation en pourcentage', 'calcul augmentation pourcentage', 'quel pourcentage de'],
        'intro' => 'Calculez des pourcentages en un instant : combien font 15 % de 200, quel pourcentage 30 représente de 120, la hausse en pourcentage de 80 à 100, et plus encore. Chaque calculateur affiche la formule utilisée pour vérifier le calcul, pour les devoirs, remises, pourboires, notes et rapports.',
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
                'heading' => 'Formules de pourcentage',
                'body' => 'X % de Y = (X / 100) x Y. X en pourcentage de Y = (X / Y) x 100. Variation en pourcentage de A à B = ((B - A) / |A|) x 100. Un résultat positif est une hausse, un résultat négatif une baisse.',
            ],
        ],
        'faqs' => [
            ['q' => 'Comment calculer un pourcentage d’un nombre ?', 'a' => 'Divisez le pourcentage par 100 et multipliez par le nombre. Par exemple, 15 % de 200 = 0,15 x 200 = 30.'],
            ['q' => 'Comment calculer une hausse en pourcentage ?', 'a' => 'Soustrayez l’ancienne valeur de la nouvelle, divisez par l’ancienne valeur et multipliez par 100. De 80 à 100 : (100 - 80) / 80 x 100 = 25 %.'],
            ['q' => 'Comment calculer une remise ?', 'a' => 'Utilisez « Diminuer un nombre d’un pourcentage ». Pour 20 % de remise sur 50 €, le prix soldé est 50 € x (1 - 0,20) = 40 €.'],
            ['q' => 'Pourquoi ne puis-je pas calculer une variation à partir de zéro ?', 'a' => 'La variation en pourcentage divise par la valeur de départ, et la division par zéro n’est pas définie : une variation à partir de 0 ne peut donc pas s’exprimer en pourcentage.'],
        ],
    ],

    'json-formatter' => [
        'name' => 'Formateur JSON',
        'title' => 'Formateur et validateur JSON : embellir du JSON en ligne',
        'description' => 'Formatez, validez et minifiez du JSON en ligne gratuitement. Erreurs indiquées à la ligne et à la colonne près. Rapide et privé, sans envoi.',
        'h1' => 'Formateur et validateur JSON',
        'tagline' => 'Embellissez, validez et minifiez du JSON avec des messages d’erreur clairs.',
        'keywords' => ['formateur json', 'validateur json', 'embellir json', 'formater json', 'minifier json'],
        'intro' => 'Collez du JSON pour l’embellir avec une indentation propre, le valider ou le minifier pour la production. Si le JSON est invalide, vous obtenez un message d’erreur clair avec la ligne et la colonne exactes pour le corriger vite. Vos données sont traitées localement et ne sont jamais envoyées.',
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
                'heading' => 'Erreurs JSON courantes',
                'body' => 'Les erreurs les plus fréquentes sont les virgules en trop après le dernier élément, les apostrophes au lieu des guillemets doubles, les clés sans guillemets et les commentaires, qui sont tous interdits en JSON standard.',
            ],
        ],
        'faqs' => [
            ['q' => 'Mon JSON est-il envoyé à un serveur ?', 'a' => 'Non. Le formatage et la validation se font dans votre navigateur : les clés d’API et données privées restent sur votre machine.'],
            ['q' => 'Quelle différence entre formater et minifier ?', 'a' => 'Formater ajoute des retours à la ligne et une indentation pour rendre le JSON lisible. Minifier supprime tous les espaces inutiles pour rendre le fichier le plus léger possible.'],
            ['q' => 'Pourquoi mon JSON affiche-t-il une erreur ?', 'a' => 'Vérifiez la ligne et la colonne indiquées dans le message. Les virgules en trop, les apostrophes et les guillemets manquants autour des clés sont les causes habituelles.'],
            ['q' => 'Peut-il traiter de gros fichiers ?', 'a' => 'Oui. Des fichiers de plusieurs mégaoctets sont formatés en bien moins d’une seconde sur la plupart des appareils.'],
        ],
    ],

    'base64-encoder-decoder' => [
        'name' => 'Encoder / décoder Base64',
        'title' => 'Encoder et décoder du Base64 en ligne : texte et fichiers',
        'description' => 'Encodez du texte ou des fichiers en Base64 et décodez le Base64 en texte. UTF-8 et Base64 compatible URL. Gratuit, rapide et privé.',
        'h1' => 'Encodeur et décodeur Base64',
        'tagline' => 'Encodez et décodez du texte et des fichiers en Base64, avec UTF-8 et variante compatible URL.',
        'keywords' => ['encoder base64', 'décoder base64', 'convertisseur base64', 'base64 en texte', 'image en base64'],
        'intro' => 'Convertissez du texte en Base64 ou décodez du Base64 en texte lisible, avec une prise en charge complète des emojis et des caractères non latins. Vous pouvez aussi transformer un fichier ou une image en data URL Base64 à intégrer dans du HTML, du CSS ou du JSON.',
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
    ],

    'what-is-my-ip' => [
        'name' => 'Quelle est mon IP',
        'title' => 'Quelle est mon adresse IP ? Voir mon IP publique',
        'description' => 'Voyez votre adresse IP publique, en IPv4 ou IPv6, ainsi que votre navigateur, système, écran et fuseau horaire. Recherche d’IP gratuite.',
        'h1' => 'Quelle est mon adresse IP ?',
        'tagline' => 'Votre adresse IP publique et les détails de votre navigateur, instantanément.',
        'keywords' => ['quelle est mon ip', 'mon adresse ip', 'recherche adresse ip', 'vérifier mon ip', 'quelle est mon adresse ip'],
        'intro' => 'Votre adresse IP publique est l’adresse que voient les sites quand vous vous connectez à Internet. Elle est attribuée par votre fournisseur d’accès, ou par votre VPN si vous en utilisez un. Ci-dessous, vous voyez votre adresse IP actuelle, si elle est en IPv4 ou en IPv6, et des détails sur votre navigateur et votre appareil.',
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
                'heading' => 'Adresse IP publique ou privée',
                'body' => 'Votre box donne à chaque appareil de la maison une adresse IP privée (souvent 192.168.x.x). Tout le réseau partage une seule adresse IP publique sur Internet : c’est celle affichée sur cette page.',
            ],
        ],
        'faqs' => [
            ['q' => 'À quoi sert mon adresse IP ?', 'a' => 'Les sites et services utilisent votre adresse IP pour vous renvoyer des données. Elle peut aussi révéler votre ville approximative et votre fournisseur d’accès.'],
            ['q' => 'Pourquoi mon adresse IP change-t-elle ?', 'a' => 'La plupart des fournisseurs d’accès attribuent des adresses IP dynamiques qui peuvent changer au redémarrage de la box. Les IP des données mobiles changent souvent.'],
            ['q' => 'Comment masquer mon adresse IP ?', 'a' => 'Utilisez un VPN ou un réseau d’anonymisation comme Tor. Les sites voient alors l’adresse IP du VPN à la place de la vôtre.'],
            ['q' => 'Conservez-vous mon adresse IP ?', 'a' => 'Non. Cet outil affiche seulement votre adresse IP et ne l’enregistre dans aucune base de données.'],
        ],
    ],

    'dice-roller' => [
        'name' => 'Lanceur de dés',
        'title' => 'Lanceur de dés : lancer des dés virtuels en ligne (D6, D20…)',
        'description' => 'Lancez de 1 à 10 dés virtuels en ligne : D4, D6, D8, D10, D12, D20 ou D100. Résultats équitables, animation 3D, total et historique.',
        'h1' => 'Lanceur de dés',
        'tagline' => 'Lancez jusqu’à 10 dés, du D4 au D100, avec animation 3D et total.',
        'keywords' => ['lancer de dés', 'lancer des dés en ligne', 'dés virtuels', 'lanceur d20', 'dé aléatoire'],
        'intro' => 'Vous avez perdu les dés d’un jeu de société ou il vous faut un D20 pour un jeu de rôle ? Ce lanceur de dés gratuit lance jusqu’à dix dés virtuels à la fois avec une animation 3D réaliste. Choisissez un dé classique à six faces ou n’importe quel dé polyédrique du D4 au D100, et voyez chaque valeur, le total et vos derniers lancers instantanément.',
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
            ['q' => 'Le lanceur de dés fonctionne-t-il sur téléphone ?', 'a' => 'Oui. Il fonctionne dans tout navigateur moderne sur téléphone, tablette et ordinateur, et vous pouvez toucher les dés pour les lancer.'],
        ],
    ],

    'coin-flip' => [
        'name' => 'Pile ou face',
        'title' => 'Pile ou face : lancer une pièce en ligne',
        'description' => 'Jouez à pile ou face en ligne avec une animation 3D réaliste. Lancez jusqu’à 100 pièces à la fois et suivez totaux et séries. Gratuit.',
        'h1' => 'Pile ou face',
        'tagline' => 'Pile ou face ? Lancez une pièce en 3D, ou jusqu’à 100 à la fois, et voyez les stats.',
        'keywords' => ['pile ou face', 'lancer une pièce', 'pile ou face en ligne', 'tirage pile ou face', 'pièce virtuelle'],
        'intro' => 'Tranchez une décision, choisissez qui commence ou faites une expérience de probabilité avec ce pile ou face en ligne gratuit. Lancez une pièce 3D qui tournoie dans les airs, ou jusqu’à 100 pièces à la fois. L’outil tient le compte des faces et des piles, la répartition en pourcentage et votre série en cours.',
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
            ['q' => 'Mes résultats sont-ils conservés ?', 'a' => 'Les totaux et votre série sont conservés tant que la page est ouverte. Rien n’est envoyé à un serveur, et Réinitialiser les stats les efface.'],
        ],
    ],

    'spin-the-wheel' => [
        'name' => 'Roue aléatoire',
        'title' => 'Roue aléatoire : tirage au sort de noms et de choix',
        'description' => 'Faites tourner une roue pour tirer au sort un nom, un gagnant ou un choix. Jusqu’à 100 entrées, animation fluide et retrait des gagnants.',
        'h1' => 'Roue aléatoire',
        'tagline' => 'Ajoutez des noms ou des choix, faites tourner et laissez la roue désigner un gagnant.',
        'keywords' => ['roue aléatoire', 'roue de la fortune en ligne', 'tirage au sort de noms', 'roue des prénoms', 'choix aléatoire'],
        'intro' => 'Impossible de décider quoi manger, qui passe ensuite ou qui gagne le concours ? Saisissez vos options dans la liste, une par ligne, et faites tourner la roue. Elle fait plusieurs tours puis ralentit jusqu’à s’arrêter sur une entrée au hasard, avant d’annoncer le gagnant. Vous pouvez retirer automatiquement chaque gagnant pour tirer des noms un par un sans répétition.',
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
        'intro' => 'Générez un nombre aléatoire entre deux valeurs, ou toute une liste. Choisissez le minimum, le maximum et le nombre de tirages, puis décidez si les doublons sont autorisés et si la liste doit être triée. Idéal pour les tombolas, le loto, les activités en classe, l’échantillonnage et les jeux.',
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
        'intro' => 'Chronométrez une course, une présentation, une recette ou une séance de sport avec ce chronomètre en ligne gratuit. Il compte au centième de seconde, enregistre les temps au tour et intermédiaires, et met en évidence vos tours le plus rapide et le plus lent. Comme il mesure le temps réellement écoulé, il reste précis même si vous changez d’onglet.',
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
            ['q' => 'Puis-je utiliser le clavier ?', 'a' => 'Oui. Espace démarre et arrête, L enregistre un tour et R réinitialise à l’arrêt.'],
            ['q' => 'Puis-je enregistrer mes temps au tour ?', 'a' => 'Appuyez sur Copier les tours pour copier tous les temps au tour et totaux, puis collez-les dans un tableur, une note ou un message.'],
        ],
    ],

    'countdown-timer' => [
        'name' => 'Minuteur',
        'title' => 'Minuteur en ligne : compte à rebours avec alarme',
        'description' => 'Minuteur en ligne gratuit en secondes, minutes ou heures avec préréglages. Une alarme sonne à la fin et l’onglet affiche le temps restant.',
        'h1' => 'Minuteur',
        'tagline' => 'Réglez des minutes ou des heures, ou touchez un préréglage. Une alarme sonne à la fin.',
        'keywords' => ['minuteur', 'minuteur en ligne', 'minuteur avec alarme', 'minuteur 5 minutes', 'compte à rebours'],
        'intro' => 'Réglez un minuteur pour la cuisine, les révisions, le sport, les réunions ou les examens. Saisissez n’importe quelle durée jusqu’à 99 heures ou touchez un préréglage comme 5 ou 25 minutes. Un anneau décompte le temps restant, l’onglet du navigateur l’affiche et une alarme sonne quand le compte à rebours atteint zéro.',
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
        'intro' => 'Se réveiller au milieu d’un cycle de sommeil explique pourquoi un réveil peut vous laisser groggy même après une nuit complète. Ce calculateur suit le rythme naturel des cycles d’environ 90 minutes : indiquez l’heure à laquelle vous devez vous lever et il suggère quand vous coucher, ou indiquez l’heure du coucher et il suggère les meilleures heures de réveil. Il peut aussi compter vos heures de sommeil et les comparer aux 7-9 heures recommandées.',
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
    ],

];
