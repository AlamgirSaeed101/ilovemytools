<?php

return [
    'text-tools' => [
        'name' => 'Outils de texte',
        'title' => 'Outils de texte gratuits : compteur de mots et majuscules',
        'description' => 'Outils de texte gratuits pour compter les mots et les caractères et changer la casse de vos textes. Résultats instantanés, sans inscription.',
        'intro' => 'Comptez les mots, consultez le temps de lecture et changez la casse en un instant. Tout fonctionne dans votre navigateur : votre texte reste privé.',
        'content' => [
            ['heading' => 'Quel outil de texte choisir ?', 'body' => 'Utilisez le Compteur de mots quand vous avez une limite à respecter : dissertations, lettres de motivation, fiches produits, publications sur les réseaux ou balises meta SEO. Il compte les mots, les caractères avec et sans espaces, les phrases et les paragraphes, et estime le temps de lecture et de parole. Utilisez le Convertisseur de casse quand les mots sont bons mais pas les majuscules : texte tapé avec Verr. Maj activé, titres ou noms de variables en camelCase ou snake_case.'],
            ['heading' => 'Ces outils de texte sont-ils privés ?', 'body' => 'Les deux fonctionnent entièrement dans votre navigateur. Le texte que vous collez est traité sur votre propre appareil et n’est jamais envoyé à notre serveur ni conservé : vous pouvez les utiliser avec des brouillons, des e-mails et des documents confidentiels. Une fois la page chargée, ils continuent de fonctionner même si la connexion coupe.'],
        ],
        'faqs' => [
            ['q' => 'Comment compter les mots d’un document ?', 'a' => 'Copiez le texte depuis Word, Google Docs ou un PDF et collez-le dans le Compteur de mots. Les totaux s’affichent aussitôt, avec les caractères, les phrases, les paragraphes et le temps de lecture.'],
            ['q' => 'Comment passer un texte de majuscules en minuscules ?', 'a' => 'Collez le texte dans le Convertisseur de casse et choisissez minuscules. Vous pouvez aussi passer en casse Titre, Phrase, camelCase, snake_case et plus, puis copier le résultat.'],
            ['q' => 'Ces outils de texte sont-ils payants ?', 'a' => 'Non. Les deux sont gratuits, sans inscription, sans limite quotidienne et sans limite de longueur de texte.'],
        ],
    ],
    'image-tools' => [
        'name' => 'Outils d’image',
        'title' => 'Outils d’image gratuits : compresser et redimensionner',
        'description' => 'Compressez, redimensionnez et convertissez des images JPG, PNG et WebP gratuitement. Tout est traité dans votre navigateur, sans envoi.',
        'intro' => 'Allégez vos images, redimensionnez vos photos au pixel près et convertissez entre JPG, PNG et WebP. Vos images ne quittent jamais votre appareil.',
        'content' => [
            ['heading' => 'Faut-il compresser ou redimensionner l’image ?', 'body' => 'Compressez quand l’image est bonne mais le fichier trop lourd, par exemple pour passer sous une limite d’envoi comme 100 Ko ou accélérer une page web : le Compresseur d’images garde les dimensions et réduit le poids. Redimensionnez quand l’image n’a pas les bonnes dimensions, comme une photo de 4000 pixels qui doit faire 1080 pixels de large pour les réseaux sociaux. Réduire une grande photo allège aussi beaucoup le fichier.'],
            ['heading' => 'JPG, PNG ou WebP : quel format choisir ?', 'body' => 'Le JPG convient le mieux aux photos, le PNG aux logos, captures d’écran et à tout ce qui a besoin de transparence, et le WebP au web, car il donne les fichiers les plus légers dans les deux cas. Selon Google, les images WebP sans perte sont environ 26 % plus légères que les PNG, et les WebP avec perte 25 à 34 % plus légères que des JPEG équivalents.'],
        ],
        'faqs' => [
            ['q' => 'Comment réduire une image à 100 Ko ?', 'a' => 'Ouvrez le Compresseur d’images, choisissez Taille cible et saisissez 100. L’outil trouve la meilleure qualité qui tient dans cette taille et ne réduit les dimensions que si nécessaire.'],
            ['q' => 'Puis-je convertir un PNG en JPG ou un WebP en PNG ici ?', 'a' => 'Oui. L’outil de redimensionnement et de conversion passe du JPG au PNG et au WebP, avec ou sans changement de taille. Les zones transparentes deviennent blanches en JPG.'],
            ['q' => 'Mes photos sont-elles envoyées sur un serveur ?', 'a' => 'Non. Les images sont traitées dans votre navigateur grâce à l’API Canvas et ne quittent jamais votre appareil.'],
        ],
    ],
    'pdf-tools' => [
        'name' => 'Outils PDF',
        'title' => 'Outils PDF gratuits : fusionner et diviser des PDF',
        'description' => 'Fusionnez et divisez des fichiers PDF en ligne gratuitement. Sans envoi, sans filigrane et sans inscription : tout reste dans votre navigateur.',
        'intro' => 'Combinez plusieurs PDF en un seul ou extrayez uniquement les pages utiles. Les fichiers sont traités sur votre appareil, sans filigrane ni limite cachée.',
        'content' => [
            ['heading' => 'Fusionner ou diviser : de quel outil PDF avez-vous besoin ?', 'body' => 'Utilisez Fusionner des PDF pour réunir plusieurs fichiers en un seul document, dans l’ordre de votre choix, par exemple un CV, une lettre de motivation et des diplômes pour une candidature. Utilisez Diviser un PDF pour l’inverse : extraire des pages dans un nouveau fichier, découper un document par plages ou enregistrer chaque page dans son propre PDF.'],
            ['heading' => 'Est-il sûr de modifier des PDF en ligne ?', 'body' => 'Sur la plupart des sites PDF, votre document est envoyé sur un serveur. Ici, les deux outils fonctionnent dans votre navigateur : contrats, relevés bancaires et autres fichiers privés ne quittent jamais votre appareil, et le résultat n’a ni filigrane ni limite de pages.'],
        ],
        'faqs' => [
            ['q' => 'Comment combiner plusieurs PDF en un seul ?', 'a' => 'Ouvrez Fusionner des PDF, ajoutez deux fichiers ou plus, mettez-les dans l’ordre avec les flèches et cliquez sur Fusionner les PDF. Le fichier combiné se télécharge aussitôt.'],
            ['q' => 'Comment extraire des pages d’un PDF ?', 'a' => 'Ouvrez Diviser un PDF, choisissez Extraire des pages, saisissez les pages voulues, par exemple 1-3, 5, et cliquez sur Diviser le PDF.'],
            ['q' => 'Puis-je fusionner des PDF protégés par mot de passe ?', 'a' => 'Pas directement. Ouvrez le fichier avec son mot de passe, enregistrez ou imprimez une copie non protégée, puis fusionnez cette copie.'],
        ],
    ],
    'calculators' => [
        'name' => 'Calculatrices',
        'title' => 'Calculatrices en ligne gratuites : âge et pourcentages',
        'description' => 'Calculatrices en ligne gratuites : âge, pourcentages, variations en pourcentage et plus. Réponses exactes et instantanées, calcul détaillé.',
        'intro' => 'Des calculatrices rapides et précises pour les calculs du quotidien : âge exact, pourcentages, hausses et remises.',
        'content' => [
            ['heading' => 'Que permettent de calculer ces calculatrices ?', 'body' => 'Le Calculateur d’âge donne l’âge exact en années, mois et jours à partir d’une date de naissance, le jour de la semaine de votre naissance et un compte à rebours jusqu’au prochain anniversaire, en tenant compte des années bissextiles. Le Calculateur de pourcentage réunit les questions courantes : X % de Y, quel pourcentage X représente de Y, la hausse ou la baisse en pourcentage entre deux nombres, et l’ajout ou le retrait d’un pourcentage comme une remise ou une taxe.'],
            ['heading' => 'Comment vérifier le résultat ?', 'body' => 'Chaque résultat affiche la formule utilisée, pour suivre le calcul d’un devoir, d’une remise, d’une augmentation ou d’un rapport. Par exemple, la variation en pourcentage de 80 à 100 est (100 - 80) / 80 x 100 = 25 %.'],
        ],
        'faqs' => [
            ['q' => 'Comment l’âge est-il calculé exactement ?', 'a' => 'On compte d’abord les années complètes, puis les mois complets, puis les jours restants. C’est la même méthode que dans les formulaires officiels.'],
            ['q' => 'Comment calculer une hausse en pourcentage ?', 'a' => 'Soustrayez l’ancienne valeur de la nouvelle, divisez par l’ancienne valeur et multipliez par 100. Le Calculateur de pourcentage le fait pour vous et affiche la formule.'],
            ['q' => 'Les calculatrices sont-elles gratuites ?', 'a' => 'Oui. Elles sont gratuites, sans inscription, et fonctionnent dans votre navigateur : rien de ce que vous saisissez n’est conservé.'],
        ],
    ],
    'generators' => [
        'name' => 'Générateurs',
        'title' => 'Générateurs gratuits : QR codes et mots de passe forts',
        'description' => 'Générez gratuitement des QR codes pour liens et Wi-Fi et des mots de passe robustes. Sans inscription, sans pistage, rien n’est conservé.',
        'intro' => 'Créez des QR codes pour des liens, le Wi-Fi et des contacts, et générez des mots de passe aléatoires robustes directement sur votre appareil.',
        'content' => [
            ['heading' => 'Des QR codes et des mots de passe créés sur votre appareil', 'body' => 'Le Générateur de QR code crée des codes pour les liens, le texte, les réseaux Wi-Fi, l’e-mail, le téléphone et les SMS, aux couleurs et tailles de votre choix, en PNG pour l’écran ou en SVG pour l’impression. Le Générateur de mots de passe crée des mots de passe aléatoires de 4 à 128 caractères grâce au générateur de nombres aléatoires cryptographiquement sûr de votre navigateur.'],
            ['heading' => 'Pourquoi ces codes et mots de passe n’expirent-ils pas ?', 'body' => 'Les QR codes sont statiques : vos données sont dans le code lui-même et non derrière un lien de redirection, ils fonctionnent donc pour toujours sans dépendre de ce site. Les mots de passe sont générés sur votre appareil et jamais envoyés : aucune copie n’existe sur un serveur.'],
        ],
        'faqs' => [
            ['q' => 'Comment créer un QR code Wi-Fi ?', 'a' => 'Choisissez Wi-Fi dans le Générateur de QR code, saisissez le nom du réseau, le mot de passe et le type de sécurité, puis téléchargez le code. Vos invités le scannent pour se connecter sans taper le mot de passe.'],
            ['q' => 'Quelle longueur pour un mot de passe ?', 'a' => 'Au moins 15 caractères, le minimum des recommandations actuelles du NIST, et 16 ou plus pour les comptes importants.'],
            ['q' => 'Puis-je utiliser les QR codes à des fins commerciales ?', 'a' => 'Oui. Les codes que vous créez sont gratuits à utiliser sur des emballages, des menus, des flyers et des cartes de visite.'],
        ],
    ],
    'games' => [
        'name' => 'Hasard et jeux',
        'title' => 'Lancer de dés, pile ou face et roue aléatoire gratuits',
        'description' => 'Lancer de dés, pile ou face, roue de tirage au sort et nombres aléatoires gratuits. Résultats équitables avec animations. Sans inscription.',
        'intro' => 'Lancez des dés, jouez à pile ou face, faites tourner une roue ou tirez des nombres au hasard. Chaque résultat est généré équitablement sur votre appareil avec un aléa sécurisé.',
        'content' => [
            ['heading' => 'Quel outil de hasard choisir ?', 'body' => 'Utilisez le Lanceur de dés pour les jeux de société et les jeux de rôle (du D4 au D100, jusqu’à 10 dés à la fois). Jouez à pile ou face pour trancher rapidement par oui ou non ou savoir qui commence. Faites tourner la roue pour tirer un nom ou un choix dans une liste de 100 entrées maximum, et utilisez le Générateur de nombres aléatoires pour les tombolas, le loto et les échantillons, avec ou sans doublons.'],
            ['heading' => 'Les résultats sont-ils vraiment aléatoires ?', 'body' => 'Tous les outils utilisent la Web Crypto API de votre navigateur, une source d’aléa cryptographiquement sûre : chaque résultat est équiprobable et imprévisible. Le résultat est fixé avant le début de l’animation, qui ne peut donc pas l’influencer.'],
        ],
        'faqs' => [
            ['q' => 'Comment tirer un nom au hasard dans une liste ?', 'a' => 'Collez les noms dans la roue, un par ligne, et appuyez sur Tourner. Cochez « Retirer le gagnant après chaque tour » pour tirer plusieurs noms sans répétition.'],
            ['q' => 'Comment générer des numéros de loto ?', 'a' => 'Utilisez le Générateur de nombres aléatoires avec le préréglage « Loto 6 sur 49 », ou choisissez votre plage et votre quantité avec « Sans doublons » coché.'],
            ['q' => 'Le pile ou face en ligne est-il équitable ?', 'a' => 'Oui. Chaque lancer a exactement 50 % de chances de tomber sur face et 50 % sur pile, grâce à un aléa sécurisé.'],
        ],
    ],
    'time-tools' => [
        'name' => 'Outils de temps',
        'title' => 'Outils de temps gratuits : chronomètre et minuteur',
        'description' => 'Un chronomètre précis avec tours et un minuteur avec alarme et préréglages rapides. Gratuits, sans inscription et toujours à l’heure, même en arrière-plan.',
        'intro' => 'Un chronomètre précis avec tours et un minuteur avec alarme. Les deux restent exacts même quand l’onglet est en arrière-plan.',
        'content' => [
            ['heading' => 'Chronomètre, minuteur ou calculateur de sommeil ?', 'body' => 'Utilisez le Chronomètre pour mesurer la durée d’une activité, avec tours et temps intermédiaires au centième de seconde. Utilisez le Minuteur quand vous savez combien de temps vous avez, pour cuisiner, réviser ou faire un Pomodoro de 25 minutes, avec une alarme à la fin. Utilisez le Calculateur de sommeil pour planifier l’heure du coucher ou du réveil selon des cycles de 90 minutes, ou pour compter vos heures de sommeil.'],
            ['heading' => 'Restent-ils précis dans un onglet en arrière-plan ?', 'body' => 'Oui. Les navigateurs ralentissent les onglets en arrière-plan, alors ces outils calculent le temps à partir d’un instant fixe de début ou de fin avec l’horloge haute résolution de l’appareil, au lieu de compter des tics. La mesure est juste à votre retour, et le Minuteur affiche aussi le temps restant dans le titre de l’onglet.'],
        ],
        'faqs' => [
            ['q' => 'Puis-je laisser tourner un minuteur en utilisant d’autres onglets ?', 'a' => 'Oui. Gardez l’onglet ouvert : le temps reste exact et l’alarme sonne bien à la fin du compte à rebours.'],
            ['q' => 'Puis-je enregistrer des temps au tour ?', 'a' => 'Oui. Appuyez sur Tour (ou L) dans le Chronomètre. Chaque tour affiche son propre temps et le total, et vous pouvez tous les copier d’un coup.'],
            ['q' => 'Combien d’heures de sommeil faut-il à un adulte ?', 'a' => 'La National Sleep Foundation recommande 7 à 9 heures par nuit pour les adultes de 18 à 64 ans.'],
        ],
    ],
    'developer-tools' => [
        'name' => 'Outils pour développeurs',
        'title' => 'Outils pour développeurs : JSON, Base64 et IP',
        'description' => 'Utilitaires gratuits pour développeurs : formatez et validez du JSON, encodez et décodez du Base64 et consultez votre adresse IP publique.',
        'intro' => 'Des utilitaires du quotidien pour développeurs et techniciens : formater du JSON, encoder en Base64 et vérifier votre adresse IP.',
        'content' => [
            ['heading' => 'Des utilitaires du quotidien pour développeurs', 'body' => 'Le Formateur JSON embellit, valide et minifie le JSON et indique la ligne et la colonne exactes de chaque erreur. L’encodeur et décodeur Base64 convertit du texte ou des fichiers vers et depuis le Base64, y compris la variante compatible URL et les data URL pour HTML et CSS. Quelle est mon IP affiche votre adresse IP publique, en IPv4 ou IPv6, et des détails sur votre navigateur et votre appareil.'],
            ['heading' => 'Est-il sûr de coller ici des données d’API ?', 'body' => 'Oui. Les outils JSON et Base64 fonctionnent entièrement dans votre navigateur : réponses d’API, jetons et fichiers de configuration ne sont jamais envoyés à un serveur. La seule requête du site est celle dont Quelle est mon IP a besoin pour lire votre adresse publique, qui vous est affichée sans être conservée.'],
        ],
        'faqs' => [
            ['q' => 'Pourquoi mon JSON est-il invalide ?', 'a' => 'Les causes les plus fréquentes sont les virgules en trop, les apostrophes au lieu des guillemets doubles, les clés sans guillemets et les commentaires. Le JSON standard n’en autorise aucun.'],
            ['q' => 'Le Base64 est-il un chiffrement ?', 'a' => 'Non. Le Base64 est un encodage que n’importe qui peut inverser : ne l’utilisez jamais pour protéger des mots de passe ou des secrets.'],
            ['q' => 'Quelle différence entre IPv4 et IPv6 ?', 'a' => 'Les adresses IPv4 ressemblent à 203.0.113.42 et sont épuisées dans la plupart des régions. Les IPv6, comme 2001:db8::1, ont été créées pour offrir bien plus d’adresses.'],
        ],
    ],
];
