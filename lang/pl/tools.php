<?php

return [

    'word-counter' => [
        'name' => 'Licznik słów',
        'title' => 'Licznik słów - zlicz słowa i znaki online',
        'description' => 'Darmowy licznik słów online. Zlicz słowa, znaki, zdania i akapity natychmiast oraz sprawdź czas czytania i gęstość słów kluczowych. Bez rejestracji.',
        'h1' => 'Licznik słów',
        'tagline' => 'Policz słowa, znaki, zdania i czas czytania w jednej chwili.',
        'keywords' => ['licznik słów', 'licznik znaków', 'liczenie słów', 'liczenie słów online', 'kalkulator czasu czytania'],
        'intro' => 'Licznik słów to narzędzie, które liczy słowa, znaki, zdania i akapity w tekście. Wklej lub wpisz swój tekst poniżej, aby liczyć słowa, znaki, zdania i akapity na żywo. Licznik pokazuje też szacowany czas czytania i mówienia oraz najczęściej używane słowa kluczowe - przydatne przy wypracowaniach, wpisach na blogu, podpisach w social media i meta opisach SEO.',
        'steps' => [
            'Wpisz albo wklej tekst do pola.',
            'Obserwuj, jak liczba słów, znaków, zdań i akapitów aktualizuje się na żywo.',
            'Sprawdź czas czytania, czas mówienia i gęstość słów kluczowych pod polem.',
            'Użyj Kopiuj albo Wyczyść, gdy skończysz.',
        ],
        'features' => [
            'Liczenie słów, znaków, zdań i akapitów na żywo',
            'Znaki ze spacjami i bez spacji',
            'Czas czytania (238 słów/min) i mówienia (150 słów/min)',
            'Gęstość najczęstszych słów kluczowych, aby nie powtarzać się za często',
            'Działa offline po wczytaniu - Twój tekst nigdy nie jest wysyłany',
        ],
        'content' => [
            [
                'heading' => 'Dlaczego liczba słów ma znaczenie?',
                'body' => 'Szkoły, uczelnie i wydawnictwa często narzucają ścisłe limity słów, a platformy społecznościowe ograniczają liczbę znaków w poście. Wyszukiwarki pokazują zwykle około 155-160 znaków meta opisu, a tytuł strony powinien mieścić się w około 60 znakach. Znając dokładną liczbę, trafiasz w te limity bez zgadywania.',
            ],
            [
                'heading' => 'Jak liczone są słowa?',
                'body' => 'Słowem jest każda grupa liter lub cyfr oddzielona spacjami lub końcem wiersza. Same znaki interpunkcyjne nie są liczone jako słowo. Zdania liczone są na podstawie znaków kończących (. ! ?), a akapity na podstawie pustych wierszy, więc wyniki odpowiadają temu, co pokazują edytory tekstu, takie jak Microsoft Word i Google Docs.',
            ],
        ],
        'faqs' => [
            ['q' => 'Czy ten licznik słów jest darmowy?', 'a' => 'Tak. Licznik słów jest całkowicie darmowy, bez rejestracji i bez limitu długości wklejanego tekstu.'],
            ['q' => 'Czy mój tekst jest zapisywany albo wysyłany?', 'a' => 'Nie. Liczenie odbywa się całkowicie w Twojej przeglądarce. Twój tekst nigdy nie jest wysyłany na nasz serwer ani nigdzie zapisywany.'],
            ['q' => 'Jak obliczany jest czas czytania?', 'a' => 'Czas czytania przyjmuje średnią prędkość czytania w myślach dorosłej osoby, czyli 238 słów na minutę. Czas mówienia zakłada 150 słów na minutę, typowe tempo prezentacji.'],
            ['q' => 'Czy "licznik słów" to to samo co "licznik tekstu"?', 'a' => 'Tak. Licznik słów, licznik tekstu i licznik znaków to różne nazwy tego samego narzędzia: liczy słowa, znaki, zdania i akapity w Twoim tekście.'],
            ['q' => 'Czy liczy znaki ze spacjami?', 'a' => 'Tak. Otrzymujesz liczbę znaków ze spacjami i bez spacji, a to właśnie liczby bez spacji dotyczą zwykle limitów znaków.'],
        ],
    ],

    'case-converter' => [
        'name' => 'Konwerter wielkości liter',
        'title' => 'Konwerter wielkości liter - wielkie, małe, tytułowe',
        'description' => 'Zmień tekst na WIELKIE LITERY, małe litery, Jak W Tytule, Jak w zdaniu, camelCase, snake_case i więcej. Darmowy, natychmiastowy i prywatny konwerter.',
        'h1' => 'Konwerter wielkości liter',
        'tagline' => 'Zmień tekst na wielkie, małe, tytułowe, zdaniowe, camel albo snake jednym kliknięciem.',
        'keywords' => ['konwerter wielkości liter', 'wielkie litery na małe', 'konwerter jak w tytule', 'jak w zdaniu', 'konwerter camelcase'],
        'intro' => 'Konwerter wielkości liter to narzędzie, które zmienia zapis tekstu, na przykład z WIELKICH LITER na małe litery. Napisałeś coś przez przypadek z włączonym Caps Lock albo potrzebujesz nagłówka Jak W Tytule? Wklej tekst i kliknij przycisk, aby go natychmiast przekonwertować. Programiści mogą też przełączać się między camelCase, PascalCase, snake_case, kebab-case i CONSTANT_CASE.',
        'steps' => [
            'Wklej swój tekst do pola.',
            'Kliknij żądany zapis, na przykład Jak W Tytule albo małe litery.',
            'Skopiuj przekonwertowany tekst albo pobierz go jako plik .txt.',
        ],
        'features' => [
            'WIELKIE LITERY, małe litery, Jak W Tytule i Jak w zdaniu',
            'camelCase, PascalCase, snake_case, kebab-case, CONSTANT_CASE',
            'zMiEnNy i oDwRoTnY zapis dla zabawnych postów',
            'Inteligentne zapisywanie tytułu, które zostawia krótkie słowa takie jak „i” czy „w” małymi literami',
            'Kopiowanie albo pobieranie wyniku',
        ],
        'content' => [
            [
                'heading' => 'Jak W Tytule czy Jak w zdaniu: czym się różnią?',
                'body' => 'Zapis Jak W Tytule pisze wielką literą główne słowa nagłówka („Szybki Przewodnik po SEO”), a krótkie słowa, takie jak i, w, z i na, zostają małe, jeśli nie zaczynają tytułu. Zapis Jak w zdaniu pisze wielką literą tylko pierwsze słowo zdania („Szybki przewodnik po SEO”), co wiele nowoczesnych witryn preferuje dla lepszej czytelności. W polskich tytułach wielką literą pisze się tylko pierwsze słowo - sprawdź wynik pod kątem polskich zasad.',
            ],
            [
                'heading' => 'Jakie są zapisy programistyczne?',
                'body' => 'camelCase jest typowy dla zmiennych w JavaScript, PascalCase dla nazw klas, snake_case dla Pythona i kolumn baz danych, kebab-case dla adresów URL i klas CSS, a CONSTANT_CASE dla stałych i zmiennych środowiskowych.',
            ],
        ],
        'faqs' => [
            ['q' => 'Jak zmienić wielkie litery na małe?', 'a' => 'Wklej tekst i kliknij „małe litery”. Każda litera jest konwertowana natychmiast, a wynik możesz skopiować jednym kliknięciem.'],
            ['q' => 'Czy Jak W Tytule pisze wielką literą każde słowo?', 'a' => 'Nie. Narzędzie stosuje typowe reguły stylu i zostawia krótkie słowa (i, w, z, na, a, o) małymi literami, o ile nie są pierwszym lub ostatnim słowem.'],
            ['q' => 'Czy jest limit długości tekstu?', 'a' => 'Nie ma praktycznego limitu. Konwersja odbywa się w przeglądarce, więc nawet długie dokumenty konwertują się natychmiast.'],
            ['q' => 'Czy działa z literami z akcentami?', 'a' => 'Tak. Litery z akcentami i znaki inne niż angielskie, takie jak é, ü czy ñ, są konwertowane poprawnie.'],
        ],
    ],

    'password-generator' => [
        'name' => 'Generator haseł',
        'title' => 'Generator haseł - silne, losowe hasła online',
        'description' => 'Generuj silne, losowe hasła z dowolną długością, symbolami i cyframi. Tworzone bezpiecznie na Twoim urządzeniu i nigdzie niewysyłane. Darmowe i szybkie.',
        'h1' => 'Generator silnych haseł',
        'tagline' => 'Twórz bezpieczne, losowe hasła jednym kliknięciem - prosto na Twoim urządzeniu.',
        'keywords' => ['generator haseł', 'generator silnych haseł', 'generator losowych haseł', 'bezpieczne hasło'],
        'intro' => 'Generator haseł to narzędzie, które tworzy losowe, trudne do odgadnięcia hasła z wybranych przez Ciebie znaków. Stwórz silne, losowe hasło, które jest praktycznie niemożliwe do odgadnięcia. Wybierz długość i rodzaje znaków, a generator użyje kryptograficznie bezpiecznego generatora liczb losowych Twojej przeglądarki. Hasła nigdy nie są wysyłane na nasz serwer.',
        'steps' => [
            'Wybierz długość hasła (zalecane 16 znaków lub więcej).',
            'Zaznacz rodzaje znaków do użycia: wielkie litery, małe litery, cyfry i symbole.',
            'Kliknij Generuj, a potem Kopiuj, aby użyć nowego hasła.',
        ],
        'features' => [
            'Długość od 4 do 128 znaków',
            'Wielkie litery, małe litery, cyfry i symbole',
            'Opcja wykluczenia podobnych znaków (l, 1, I, O, 0)',
            'Wskaźnik siły oparty na rzeczywistej entropii',
            'Korzysta z crypto.getRandomValues - bezpiecznie i bez obciążeń',
        ],
        'content' => [
            [
                'heading' => 'Co sprawia, że hasło jest silne?',
                'body' => 'Najważniejsza jest długość. Każdy dodatkowy znak wielokrotnie zwiększa liczbę możliwych kombinacji. Hasło o długości 16 znaków, z wielkimi i małymi literami, cyframi i symbolami, ma ponad 100 bitów entropii, co przy obecnym sprzęcie oznacza miliardy lat potrzebne na złamanie metodą brute-force.',
            ],
            [
                'heading' => 'Jak dbać o bezpieczeństwo haseł?',
                'body' => 'Używaj innego hasła dla każdego konta, przechowuj je w menedżerze haseł i włącz weryfikację dwuetapową, gdziekolwiek jest dostępna. Nigdy nie używaj ponownie hasła, które wyciekło w jakimś naruszeniu danych.',
            ],
        ],
        'faqs' => [
            ['q' => 'Czy ten generator haseł jest bezpieczny?', 'a' => 'Tak. Hasła są generowane w Twojej przeglądarce za pomocą Web Crypto API. Nic nie jest wysyłane na nasz serwer, logowane ani zapisywane.'],
            ['q' => 'Jak długie powinno być moje hasło?', 'a' => 'Co najmniej 15 znaków, czyli minimum w aktualnych wytycznych NIST (SP 800-63B), a 16 lub więcej dla ważnych kont, takich jak e-mail czy bankowość.'],
            ['q' => 'Co robi opcja „wyklucz podobne znaki”?', 'a' => 'Usuwa znaki, które wyglądają podobnie, takie jak l, 1, I, O i 0, dzięki czemu hasło jest łatwiejsze do odczytania i wpisania ręcznie.'],
            ['q' => 'Co to jest entropia hasła?', 'a' => 'Entropia, mierzona w bitach, określa, jak nieprzewidywalne jest hasło. Każdy dodatkowy bit podwaja liczbę prób potrzebnych atakującemu. 80+ bitów to silne hasło, a 100+ bitów to wynik doskonały.'],
        ],
        'table' => [
            'caption' => 'Długość hasła a siła (entropia w bitach)',
            'headers' => ['Długość', 'Litery i cyfry (62 znaki)', 'Litery, cyfry i symbole (89 znaków)'],
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
        'name' => 'Generator kodów QR',
        'title' => 'Generator kodów QR - darmowe kody dla URL, Wi-Fi i więcej',
        'description' => 'Twórz darmowe kody QR dla linków, tekstu, Wi-Fi, e-maili, telefonów i SMS. Własne kolory i rozmiary, pobierz PNG lub SVG. Bez rejestracji, kody nie wygasają.',
        'h1' => 'Darmowy generator kodów QR',
        'tagline' => 'Twórz kody QR do linków, Wi-Fi, e-maili, telefonów i SMS. Pobierz PNG albo SVG.',
        'keywords' => ['generator kodów qr', 'darmowy generator kodów qr', 'kod qr wifi', 'tworzenie kodów qr', 'kod qr dla url'],
        'intro' => 'Generator kodów QR to narzędzie, które zmienia link, tekst albo dane Wi-Fi w kwadratowy kod, jaki można zeskanować aparatem telefonu. Stwórz kod QR dla linku do strony, zwykłego tekstu, sieci Wi-Fi, e-maila, numeru telefonu lub SMS-a w kilka sekund. Wybierz kolory i rozmiar, a potem pobierz plik PNG w wysokiej jakości do ekranów albo SVG do druku. To statyczne kody QR, dlatego działają na zawsze i nigdy nie wygasają.',
        'steps' => [
            'Wybierz typ kodu QR: URL, Tekst, Wi-Fi, E-mail, Telefon albo SMS.',
            'Wypełnij dane. Podgląd aktualizuje się na bieżąco.',
            'Dostosuj rozmiar, kolory i korekcję błędów, jeśli chcesz.',
            'Pobierz jako PNG albo SVG i przetestuj aparatem telefonu.',
        ],
        'features' => [
            'Kody QR dla URL, tekstu, Wi-Fi, e-mail, telefonu i SMS',
            'Własne kolory pierwszego planu i tła',
            'Rozmiary od 128px do 1024px',
            'Poziomy korekcji błędów L, M, Q i H',
            'Pobieranie PNG i SVG - darmowe do użytku komercyjnego',
            'Statyczne kody, które nigdy nie wygasają, bez śledzenia',
        ],
        'content' => [
            [
                'heading' => 'Jak zrobić kod QR do Wi-Fi?',
                'body' => 'Wybierz typ Wi-Fi, wpisz nazwę swojej sieci (SSID), hasło i typ zabezpieczeń. Goście mogą zeskanować kod aparatem telefonu i połączyć się z siecią bez wpisywania hasła, co jest idealne w domu, kawiarni czy biurze.',
            ],
            [
                'heading' => 'Jak zrobić kod QR, który zawsze się skanuje?',
                'body' => 'Zachowaj silny kontrast, z ciemnym kodem na jasnym tle, zostaw margines wokół kodu i wydrukuj go przynajmniej w rozmiarze 2 x 2 cm. Użyj wyższego poziomu korekcji błędów, jeśli kod może się porysować albo zabrudzić.',
            ],
        ],
        'faqs' => [
            ['q' => 'Czy te kody QR wygasają?', 'a' => 'Nie. To statyczne kody QR z danymi zakodowanymi bezpośrednio, więc działają na zawsze i nie zależą od naszej witryny.'],
            ['q' => 'Czy mogę używać kodów QR komercyjnie?', 'a' => 'Tak. Możesz bezpłatnie używać wygenerowanych kodów QR na ulotkach, opakowaniach, w menu i na wizytówkach.'],
            ['q' => 'Pobrać PNG czy SVG?', 'a' => 'PNG najlepiej sprawdza się na stronach internetowych i w dokumentach. SVG to format wektorowy, który zostaje ostry w każdym rozmiarze - idealny do druku.'],
            ['q' => 'Co to jest korekcja błędów?', 'a' => 'Korekcja błędów pozwala zeskanować kod QR, nawet gdy jego część jest uszkodzona. Poziom L odtwarza około 7% kodu, a poziom H około 30%, ale wyższe poziomy sprawiają, że kod jest gęstszy.'],
            ['q' => 'Czemu mój kod QR się nie skanuje?', 'a' => 'Najczęściej kolory są zbyt podobne albo odwrócone (jasny kod na ciemnym tle). Użyj ciemnego kodu na jasnym tle z dobrym kontrastem.'],
        ],
        'table' => [
            'caption' => 'Poziomy korekcji błędów kodu QR',
            'headers' => ['Poziom', 'Odtwarza do', 'Dobry do'],
            'rows' => [
                ['L', '7%', 'Czystych ekranów i kodów z dużą ilością danych'],
                ['M', '15%', 'Większości codziennych zastosowań (najczęstszy wybór)'],
                ['Q', '25%', 'Wydrukowanych kodów, które mogą się zabrudzić'],
                ['H', '30%', 'Trudnych warunków, np. etykiet fabrycznych'],
            ],
        ],
    ],

    'image-compressor' => [
        'name' => 'Kompresor obrazów',
        'title' => 'Kompresja zdjęć - kompresuj JPG, PNG i WebP online',
        'description' => 'Kompresuj zdjęcia JPG, PNG i WebP online za darmo. Zmniejsz rozmiar do 100KB bez widocznej utraty jakości. Obrazy nie opuszczają urządzenia.',
        'h1' => 'Kompresor obrazów',
        'tagline' => 'Zmniejsz rozmiar plików JPG, PNG i WebP - nawet do konkretnej wartości, jak 100KB.',
        'keywords' => ['kompresor obrazów', 'kompresja zdjęć', 'kompresja zdjęcia do 100kb', 'zmniejszenie rozmiaru obrazu', 'kompresja jpg'],
        'intro' => 'Kompresor obrazów to narzędzie, które zmniejsza rozmiar plików graficznych, zachowując ich wygląd. Zmniejsz swoje zdjęcia bez widocznej utraty jakości. Wrzuć jeden albo wiele plików JPG, PNG lub WebP, wybierz poziom jakości albo rozmiar docelowy, na przykład 100KB, i pobierz skompresowane obrazy. Kompresja odbywa się w Twojej przeglądarce, więc Twoje zdjęcia nigdy nie są wysyłane.',
        'steps' => [
            'Przeciągnij i upuść obrazy albo kliknij, aby wybrać pliki (JPG, PNG lub WebP).',
            'Wybierz poziom jakości albo ustaw rozmiar docelowy, na przykład 100 KB.',
            'Opcjonalnie wybierz format wyjściowy i maksymalną szerokość.',
            'Pobierz każdy obraz albo wszystkie jako ZIP.',
        ],
        'features' => [
            'Kompresja wsadowa do 30 obrazów na raz',
            'Tryb rozmiaru docelowego, np. „kompresuj do 100KB”',
            'Konwersja do WebP dla największej oszczędności',
            'Opcjonalna maksymalna szerokość do zmniejszania ogromnych zdjęć',
            'Rozmiar plików przed i po z % zaoszczędzonego miejsca',
            '100% prywatne - przetwarzane w Twojej przeglądarce',
        ],
        'content' => [
            [
                'heading' => 'Czemu kompresować obrazy?',
                'body' => 'Duże obrazy to najczęstsza przyczyna wolnego wczytywania stron, a szybkość strony jest czynnikiem rankingowym Google. Mniejsze obrazy szybciej też się wysyła na formularze i portale rekrutacyjne z limitami, takimi jak 100KB, 200KB czy 1MB.',
            ],
            [
                'heading' => 'Który format wybrać?',
                'body' => 'JPG jest najlepszy do zdjęć. PNG zachowuje przezroczystość i ostre krawędzie w logo i zrzutach ekranu, ale jego pliki są duże. WebP daje najmniejsze pliki dla zdjęć i grafik i jest wspierany przez wszystkie nowoczesne przeglądarki.',
            ],
        ],
        'faqs' => [
            ['q' => 'Jak skompresować obraz do 100KB?', 'a' => 'Wybierz „Rozmiar docelowy”, wpisz 100 i kliknij Kompresuj. Narzędzie znajduje najlepszą jakość, która zmieści się w limicie, i zmniejsza wymiary tylko, jeśli to konieczne.'],
            ['q' => 'Czy moje obrazy są wysyłane na serwer?', 'a' => 'Nie. Obrazy są kompresowane w Twojej przeglądarce za pomocą Canvas API. Nigdy nie opuszczają Twojego urządzenia.'],
            ['q' => 'Czy kompresja zmniejszy jakość?', 'a' => 'Przy domyślnej jakości (75%) większość ludzi nie zauważa różnicy, a rozmiar plików często spada o 50-80%.'],
            ['q' => 'Czemu mój PNG zmniejszył się tylko odrobinę?', 'a' => 'PNG jest formatem bezstratnym. Aby znacząco zmniejszyć rozmiar, wybierz WebP albo JPG jako format wyjściowy. Użyj WebP, jeśli potrzebujesz zachować przezroczystość.'],
            ['q' => 'Jak zmniejszyć rozmiar JPG online?', 'a' => 'Wgraj swój JPG, wybierz „Rozmiar docelowy” lub jakość około 60-80% i kliknij Kompresuj. Dla zdjęć jakość JPG 70-80% zwykle wystarcza, by znacznie zmniejszyć rozmiar bez widocznej utraty jakości.'],
        ],
        'table' => [
            'caption' => 'Który format obrazu wybrać',
            'headers' => ['Format', 'Najlepszy do', 'Przezroczystość'],
            'rows' => [
                ['JPG', 'Zdjęć', 'Nie'],
                ['PNG', 'Logo, zrzutów ekranu, ostrej grafiki', 'Tak'],
                ['WebP', 'Stron internetowych (najmniejsze pliki dla zdjęć i grafik)', 'Tak'],
            ],
        ],
    ],

    'image-resizer' => [
        'name' => 'Zmiana rozmiaru obrazu',
        'title' => 'Zmiana rozmiaru obrazu - skaluj i konwertuj JPG, PNG, WebP',
        'description' => 'Zmień rozmiar obrazów na konkretne piksele lub procent i konwertuj między JPG, PNG i WebP. Darmowe narzędzie, które zachowuje prywatność Twoich zdjęć.',
        'h1' => 'Zmiana rozmiaru i konwersja obrazu',
        'tagline' => 'Zmień rozmiar na konkretne piksele albo procent i konwertuj JPG, PNG i WebP.',
        'keywords' => ['zmiana rozmiaru obrazu', 'zmień rozmiar zdjęcia', 'png na jpg', 'jpg na png', 'webp na jpg', 'konwerter obrazów'],
        'intro' => 'Narzędzie do zmiany rozmiaru obrazu zmienia szerokość i wysokość zdjęcia, a konwerter zmienia jego format pliku. Zmień rozmiar zdjęcia na konkretne wymiary do social media, formularza na paszport albo swojej strony, albo przeskaluj je procentowo. Możesz też zmienić format, na przykład PNG na JPG albo WebP na PNG. Wszystko odbywa się w Twojej przeglądarce.',
        'steps' => [
            'Wybierz albo upuść obraz (JPG, PNG, WebP, GIF lub BMP).',
            'Wpisz nową szerokość i wysokość albo wybierz procent.',
            'Wybierz format wyjściowy i jakość.',
            'Kliknij Pobierz, aby zapisać zmieniony obraz.',
        ],
        'features' => [
            'Zmiana rozmiaru w pikselach albo procentach',
            'Blokada proporcji, aby uniknąć rozciągnięcia',
            'Konwersja między JPG, PNG i WebP',
            'Kontrola jakości dla JPG i WebP',
            'Podgląd na żywo z nowym rozmiarem pliku',
        ],
        'content' => [
            [
                'heading' => 'Jaki rozmiar powinien mieć mój obraz?',
                'body' => 'Posty na Instagramie dobrze wyglądają w rozmiarze 1080 x 1080 pikseli, Facebook i LinkedIn udostępniają obrazy w 1200 x 630, miniatury YouTube w 1280 x 720, a główne zdjęcia na stronie zwykle nie wymagają więcej niż 1920 pikseli szerokości.',
            ],
            [
                'heading' => 'Jak przekonwertować PNG na JPG?',
                'body' => 'JPG nie wspiera przezroczystości, dlatego przezroczyste obszary są wypełniane białym kolorem przy konwersji PNG na JPG. Jeśli chcesz zachować przezroczystość, wybierz PNG albo WebP jako format wyjściowy.',
            ],
        ],
        'faqs' => [
            ['q' => 'Jak zmienić rozmiar obrazu bez rozciągania?', 'a' => 'Zostaw zaznaczoną opcję „Zablokuj proporcje”. Gdy zmienisz szerokość, wysokość zaktualizuje się automatycznie, zachowując oryginalne proporcje.'],
            ['q' => 'Czy mogę przekonwertować WebP na JPG?', 'a' => 'Tak. Otwórz swój obraz WebP, wybierz JPG jako format wyjściowy i pobierz.'],
            ['q' => 'Czy zmiana rozmiaru zmniejsza jakość?', 'a' => 'Zmniejszenie obrazu zachowuje ostrość. Znaczne powiększenie go może wyglądać rozmyte, bo nie można stworzyć nowych szczegółów.'],
            ['q' => 'Jaki jest maksymalny rozmiar?', 'a' => 'Obrazy wyjściowe mogą mieć do 10 000 pikseli na każdej stronie, co jest w zasięgu wszystkich nowoczesnych przeglądarek.'],
        ],
        'table' => [
            'caption' => 'Popularne rozmiary obrazów',
            'headers' => ['Zastosowanie', 'Rozmiar (piksele)'],
            'rows' => [
                ['Kwadratowy post na Instagramie', '1080 × 1080'],
                ['Udostępniony obraz na Facebooku i LinkedIn', '1200 × 630'],
                ['Miniatura YouTube', '1280 × 720'],
                ['Pełnej szerokości obraz na stronie', 'do 1920 szerokości'],
            ],
        ],
    ],

    'jpg-to-pdf' => [
        'name' => 'JPG do PDF',
        'title' => 'Konwerter JPG do PDF - połącz obrazy online',
        'description' => 'Konwertuj obrazy JPG, PNG lub WebP do PDF online za darmo. Zmień kolejność zdjęć, wybierz rozmiar strony, orientację i marginesy. Bez znaku wodnego.',
        'h1' => 'JPG do PDF',
        'tagline' => 'Połącz obrazy JPG, PNG i WebP w jeden plik PDF.',
        'keywords' => ['jpg do pdf', 'jpeg do pdf', 'konwerter jpg do pdf', 'konwertuj jpg na pdf', 'obraz do pdf'],
        'intro' => 'Konwerter JPG do PDF zmienia obrazy JPG, PNG lub WebP w jeden dokument PDF. Dodaj wiele zdjęć, zmień ich kolejność i wybierz rozmiar strony, orientację i marginesy, zanim połączysz je w jeden dokument. Ten konwerter jpg do pdf działa całkowicie na Twoim urządzeniu, więc Twoje obrazy nigdy nie są wysyłane na serwer.',
        'steps' => [
            'Dodaj jeden lub więcej obrazów JPG, PNG lub WebP, upuszczając je albo klikając, aby je wybrać.',
            'Zmień kolejność obrazów strzałkami w górę i w dół, jeśli trzeba.',
            'Wybierz rozmiar strony, orientację i margines.',
            'Kliknij Konwertuj do PDF i pobierz plik.',
        ],
        'features' => [
            'Połącz obrazy JPG, PNG i WebP w jeden PDF',
            'Zmień kolejność albo usuń obrazy przed konwersją',
            'Rozmiary stron A4, Letter albo Dopasuj do obrazu',
            'Automatyczna albo ręczna orientacja stron',
            'Regulowane marginesy wokół każdego zdjęcia',
            'Prywatne - obrazy nigdy nie opuszczają Twojego urządzenia',
        ],
        'content' => [
            [
                'heading' => 'Jaki rozmiar strony wybrać?',
                'body' => 'A4 i Letter dodają biały margines wokół zdjęć, które nie pasują do kształtu strony, co dobrze sprawdza się w dokumentach i druku. Opcja Dopasuj do obrazu ustawia rozmiar strony PDF tak, aby odpowiadał każdemu zdjęciu, zachowując cały obraz widoczny bez białych ramek - przydatne, gdy potrzebujesz tylko szybkiej kopii zdjęcia w PDF.',
            ],
            [
                'heading' => 'Czemu konwertować JPG do PDF?',
                'body' => 'Pojedynczy plik PDF łatwiej wysłać e-mailem, wydrukować i wgrać do formularzy niż kilka osobnych plików graficznych. Połączenie zeskanowanych stron, rachunków albo zdjęć w jeden PDF utrzymuje też ich odpowiednią kolejność i zapobiega ich pomieszaniu.',
            ],
        ],
        'faqs' => [
            ['q' => 'Czy mogę połączyć wiele obrazów w jeden PDF?', 'a' => 'Tak. Dodaj tyle obrazów JPG, PNG lub WebP, ile chcesz, ułóż je strzałkami w żądanej kolejności, a zostaną połączone w jeden plik PDF.'],
            ['q' => 'Czy ten konwerter JPG do PDF dodaje znak wodny?', 'a' => 'Nie. PDF zawiera tylko Twoje obrazy, bez znaku wodnego, logo czy dodatkowych stron.'],
            ['q' => 'Czy mogę konwertować też obrazy PNG i WebP, nie tylko JPG?', 'a' => 'Tak. Obrazy JPG, PNG i WebP są wszystkie wspierane i można je mieszać w jednym PDF.'],
            ['q' => 'Co robi ustawienie marginesu?', 'a' => 'Dodaje wolną przestrzeń wokół każdego obrazu na stronie. Wybierz Brak, aby obraz sięgał do krawędzi, albo większy margines dla wyglądu bardziej jak dokument.'],
            ['q' => 'Czy jakość mojego obrazu jest zmniejszana?', 'a' => 'Obrazy JPG i PNG są wstawiane w oryginalnej jakości. Obrazy WebP są najpierw konwertowane do PNG, co zachowuje je bezstratnie.'],
        ],
    ],

    'webp-to-png' => [
        'name' => 'WebP do PNG',
        'title' => 'Konwerter WebP do PNG - darmowy, prywatny, wsadowy',
        'description' => 'Konwertuj WebP do PNG online za darmo. Konwersja wsadowa do 30 obrazów na raz, zachowana przezroczystość i pobieranie ZIP. Obrazy nie opuszczają urządzenia.',
        'h1' => 'Konwerter WebP do PNG',
        'tagline' => 'Zmień obrazy WebP na PNG w kilka sekund, z zachowaną przezroczystością.',
        'keywords' => ['webp do png', 'konwertuj webp do png', 'konwerter webp do png', 'konwerter webp', 'zmień webp na png'],
        'intro' => 'WebP to format obrazów stworzony przez Google, który sprawia, że pliki są małe, ale niektóre aplikacje, edytory i formularze nadal go nie obsługują. Ten konwerter WebP do PNG zmienia obrazy WebP na PNG, format, który otwiera się wszędzie, i zachowuje przezroczyste tła bez zmian. Wrzuć jeden obraz albo całą partię i pobierz wyniki pojedynczo albo jako ZIP.',
        'steps' => [
            'Upuść obrazy WebP do pola albo kliknij, aby je wybrać (do 30 na raz).',
            'Każdy obraz jest konwertowany do PNG od razu, w Twojej przeglądarce.',
            'Kliknij Pobierz przy obrazie albo Pobierz wszystko (ZIP) dla całej partii.',
            'Użyj Wyczyść wszystko, aby zacząć od nowa z innymi obrazami.',
        ],
        'features' => [
            'Konwertuje WebP do PNG z zachowaną przezroczystością',
            'Konwersja wsadowa do 30 obrazów',
            'Pobieranie ZIP dla kilku plików',
            'Przyjmuje też JPG, GIF i BMP',
            '100% prywatne: niczego nie wysyłamy',
        ],
        'content' => [
            [
                'heading' => 'Czemu konwertować WebP do PNG?',
                'body' => 'Przeglądarki zapisują wiele obrazów z internetu jako WebP, ale starsze edytory zdjęć, dokumenty biurowe i niektóre formularze przyjmują tylko PNG albo JPG. PNG jest bezstratny i szeroko wspierany, więc konwersja daje plik, który otworzy się wszędzie bez utraty szczegółów. Cena to rozmiar: pliki PNG są zwykle większe niż WebP.',
            ],
            [
                'heading' => 'Czy konwersja WebP do PNG zmniejsza jakość?',
                'body' => 'Sama konwersja nie powoduje utraty jakości, bo PNG jest bezstratny: każdy piksel zdekodowanego obrazu WebP zostaje zapisany dokładnie. Jeśli oryginalny WebP był zapisany ze stratną kompresją, ta wcześniejsza utrata zostaje, ale nic nowego nie jest dodawane.',
            ],
        ],
        'faqs' => [
            ['q' => 'Jak przekonwertować WebP na PNG?', 'a' => 'Upuść plik WebP do pola powyżej. Jest konwertowany na PNG natychmiast, a wynik możesz pobrać jednym kliknięciem.'],
            ['q' => 'Czy przezroczystość jest zachowana?', 'a' => 'Tak. PNG wspiera przezroczystość, więc przezroczyste obszary obrazu WebP zostają przezroczyste po konwersji.'],
            ['q' => 'Czemu PNG jest większy niż WebP?', 'a' => 'WebP używa bardziej wydajnej kompresji. PNG zapisuje każdy piksel bez utraty, więc ten sam obraz zwykle zajmuje więcej miejsca.'],
            ['q' => 'Czy moje obrazy są wysyłane?', 'a' => 'Nie. Konwersja odbywa się w Twojej przeglądarce za pomocą Canvas API, a Twoje obrazy nigdy nie opuszczają Twojego urządzenia.'],
        ],
    ],

    'png-to-jpg' => [
        'name' => 'PNG do JPG',
        'title' => 'Konwerter PNG do JPG - konwertuj PNG na JPEG za darmo',
        'description' => 'Konwertuj PNG do JPG (JPEG) online za darmo. Konwersja wsadowa do 30 obrazów, wybór jakości i pobieranie ZIP. Nic nie jest wysyłane na serwer.',
        'h1' => 'Konwerter PNG do JPG',
        'tagline' => 'Konwertuj obrazy PNG na JPG (JPEG) masowo, z regulowaną jakością.',
        'keywords' => ['png do jpg', 'png do jpeg', 'konwertuj png na jpg', 'konwerter png do jpg', 'konwerter png'],
        'intro' => 'PNG jest formatem bezstratnym, świetnym do grafiki, ale daje duże pliki, natomiast JPG (zwany też JPEG) jest mniejszy i przyjmowany praktycznie wszędzie. Ten konwerter PNG do JPG zmienia jeden lub wiele obrazów PNG na JPG z wybraną przez Ciebie jakością. Przezroczyste obszary są wypełniane białym kolorem, ponieważ JPG nie ma przezroczystości.',
        'steps' => [
            'Upuść obrazy PNG do pola albo kliknij, aby je wybrać (do 30 na raz).',
            'Dostosuj jakość, jeśli chcesz mniejsze pliki (90% lub więcej wygląda identycznie).',
            'Każdy obraz jest konwertowany do JPG natychmiast, w Twojej przeglądarce.',
            'Pobierz każdy plik JPG albo wszystkie razem jako ZIP.',
        ],
        'features' => [
            'Konwertuje PNG do JPG (JPEG) masowo',
            'Regulowana jakość JPG od 50% do 100%',
            'Przezroczyste obszary wypełnione białym kolorem',
            'Pobieranie ZIP dla kilku plików',
            'Prywatne: obrazy są przetwarzane na Twoim urządzeniu',
        ],
        'content' => [
            [
                'heading' => 'Kiedy konwertować PNG na JPG?',
                'body' => 'Konwertuj PNG na JPG, gdy jest to zdjęcie albo szczegółowy obraz, a plik jest za duży do e-maila, strony internetowej albo formularza, albo gdy strona wymaga po prostu JPG. Zachowaj PNG do logo, ikon, zrzutów ekranu z ostrym tekstem i wszystkiego, co wymaga przezroczystego tła.',
            ],
            [
                'heading' => 'Czy JPG to to samo co JPEG?',
                'body' => 'Tak. JPG i JPEG to dwie nazwy tego samego formatu; trzyliterowe rozszerzenie .jpg pochodzi ze starszych wersji Windows, które dopuszczały tylko trzy znaki. Pliki zapisane przez ten konwerter mają rozszerzenie .jpg, które przyjmuje każde urządzenie i strona internetowa.',
            ],
        ],
        'faqs' => [
            ['q' => 'Jak przekonwertować PNG na JPG?', 'a' => 'Upuść PNG do pola powyżej i jest od razu konwertowany na JPG. Kliknij Pobierz, aby go zapisać.'],
            ['q' => 'Co dzieje się z przezroczystym tłem?', 'a' => 'JPG nie może zapisać przezroczystości, więc przezroczyste obszary są wypełniane białym kolorem podczas konwersji.'],
            ['q' => 'Jaką jakość wybrać?', 'a' => 'Domyślne 92% wygląda tak samo jak oryginał. Około 80% daje zauważalnie mniejsze pliki przy niewielkiej zmianie wyglądu.'],
            ['q' => 'Czy mogę konwertować wiele PNG na raz?', 'a' => 'Tak. Upuść do 30 obrazów na raz i pobierz je wszystkie razem jako plik ZIP.'],
        ],
    ],

    'jpg-to-png' => [
        'name' => 'JPG do PNG',
        'title' => 'Konwerter JPG do PNG - konwertuj JPEG na PNG za darmo',
        'description' => 'Konwertuj obrazy JPG albo JPEG do PNG online za darmo. Wynik bezstratny, konwersja wsadowa do 30 plików i pobieranie ZIP. Nic nie opuszcza Twojego urządzenia.',
        'h1' => 'Konwerter JPEG do PNG',
        'tagline' => 'Konwertuj obrazy JPG i JPEG na bezstratny PNG masowo.',
        'keywords' => ['jpeg do png', 'jpg do png', 'konwertuj jpg na png', 'konwerter jpeg do png', 'zmień jpg na png'],
        'intro' => 'PNG jest formatem bezstratnym, więc po zapisaniu obrazu jako PNG można go edytować i zapisywać ponownie bez pogorszenia jakości. Ten konwerter JPEG do PNG zmienia zdjęcia JPG i JPEG na pliki PNG, pojedynczo albo w partii do 30 plików, bezpośrednio w Twojej przeglądarce.',
        'steps' => [
            'Upuść obrazy JPG albo JPEG do pola albo kliknij, aby je wybrać.',
            'Każdy obraz jest konwertowany do PNG od razu.',
            'Kliknij Pobierz przy obrazie albo Pobierz wszystko (ZIP).',
            'Użyj Wyczyść wszystko, aby skonwertować kolejny zestaw.',
        ],
        'features' => [
            'Konwertuje JPG i JPEG do bezstratnego PNG',
            'Konwersja wsadowa do 30 obrazów',
            'Pobieranie ZIP dla kilku plików',
            'Przyjmuje też WebP, GIF i BMP',
            'Prywatne: nic nie jest wysyłane',
        ],
        'content' => [
            [
                'heading' => 'Czemu konwertować JPG na PNG?',
                'body' => 'Konwertuj do PNG, gdy będziesz wielokrotnie edytować obraz, dodawać go do projektu graficznego albo gdy strona lub aplikacja wymaga PNG. Każde zapisanie JPG traci odrobinę jakości; PNG tego nie robi, więc jest bezpieczniejszym formatem roboczym.',
            ],
            [
                'heading' => 'Czy konwersja sprawi, że obraz będzie przezroczysty albo ostrzejszy?',
                'body' => 'Nie. Konwersja zachowuje obraz dokładnie takim, jaki jest: JPG nie ma żadnej przezroczystości do przeniesienia, a szczegóły utracone wcześniej przez kompresję JPG nie da się przywrócić. Plik PNG będzie też zwykle większy niż JPG, bo PNG zapisuje każdy piksel bez utraty.',
            ],
        ],
        'faqs' => [
            ['q' => 'Jak przekonwertować JPG na PNG?', 'a' => 'Upuść JPG do pola powyżej. Jest od razu konwertowany na PNG, a wynik możesz pobrać jednym kliknięciem.'],
            ['q' => 'Czy jest różnica między JPG i JPEG?', 'a' => 'Nie. To dwie nazwy tego samego formatu, a obie konwertują się w ten sam sposób.'],
            ['q' => 'Czemu plik PNG jest większy?', 'a' => 'PNG jest bezstratny, więc zachowuje każdy piksel dokładnie. JPG oszczędza miejsce, odrzucając szczegóły, co sprawia, że jego pliki są mniejsze.'],
            ['q' => 'Czy moje zdjęcia są wysyłane?', 'a' => 'Nie. Wszystko odbywa się w Twojej przeglądarce i Twoje zdjęcia nigdy nie opuszczają Twojego urządzenia.'],
        ],
    ],

    'merge-pdf' => [
        'name' => 'Połącz PDF',
        'title' => 'Połącz PDF - scal pliki PDF online za darmo',
        'description' => 'Połącz pliki PDF w jeden dokument online za darmo. Zmień kolejność plików, bez znaku wodnego, bez rejestracji. PDF-y łączone w Twojej przeglądarce.',
        'h1' => 'Połącz pliki PDF',
        'tagline' => 'Scal wiele plików PDF w jeden - bez znaku wodnego, bez wysyłania na serwer.',
        'keywords' => ['połącz pdf', 'scal pdf', 'łączenie plików pdf', 'łączenie pdf online', 'scalanie pdf za darmo'],
        'intro' => 'Łączenie PDF-ów oznacza scalenie kilku plików PDF w jeden dokument. Scal kilka plików PDF w jeden dokument w wybranej przez Ciebie kolejności. W przeciwieństwie do wielu witryn z PDF-ami, Twoje pliki są łączone w Twojej przeglądarce, więc poufne dokumenty nigdy nie trafiają na serwer, a wynik nie ma znaku wodnego.',
        'steps' => [
            'Dodaj dwa lub więcej plików PDF, upuszczając je albo klikając, aby je wybrać.',
            'Ustaw je w odpowiedniej kolejności strzałkami w górę i w dół.',
            'Kliknij Połącz PDF.',
            'Pobierz połączony plik PDF.',
        ],
        'features' => [
            'Połącz do 50 plików PDF na raz',
            'Zmień kolejność albo usuń pliki przed połączeniem',
            'Pokazuje liczbę stron każdego pliku',
            'Bez znaku wodnego i bez limitów stron',
            'Prywatne - pliki nigdy nie opuszczają Twojego urządzenia',
        ],
        'content' => [
            [
                'heading' => 'Czemu łączyć pliki PDF?',
                'body' => 'Wiele podań o pracę, formularzy wizowych i portali uniwersyteckich przyjmuje tylko jeden plik. Połączenie CV, listu motywacyjnego i certyfikatów w jeden PDF utrzymuje wszystko razem i w odpowiedniej kolejności.',
            ],
            [
                'heading' => 'Czy można połączyć PDF chroniony hasłem?',
                'body' => 'Zaszyfrowanych plików PDF nie można połączyć, dopóki nie zostanie usunięta ochrona hasłem. Otwórz plik w swoim czytniku PDF za pomocą hasła i zapisz lub wydrukuj kopię bez ochrony, a potem połącz tę kopię.',
            ],
        ],
        'faqs' => [
            ['q' => 'Czy łączenie PDF-ów tutaj jest bezpieczne?', 'a' => 'Tak. Pliki są przetwarzane lokalnie w Twojej przeglądarce za pomocą JavaScript i nigdy nie są wysyłane, więc zostają całkowicie prywatne.'],
            ['q' => 'Czy jest znak wodny?', 'a' => 'Nie. Połączony PDF nie ma znaku wodnego, logo ani dodanych stron.'],
            ['q' => 'Ile plików PDF mogę połączyć?', 'a' => 'Do 50 plików na raz. Praktyczny limit zależy od pamięci Twojego urządzenia, a większość urządzeń bez problemu obsługuje kilkaset stron.'],
            ['q' => 'Czy linki i zakładki zostaną zachowane?', 'a' => 'Treść stron, obrazy i tekst są zachowane dokładnie. Niektóre funkcje interaktywne, takie jak zakładki i pola formularzy, mogą się nie przenieść.'],
        ],
    ],

    'split-pdf' => [
        'name' => 'Podziel PDF',
        'title' => 'Podziel PDF - wyodrębnij strony z PDF online za darmo',
        'description' => 'Podziel PDF na osobne pliki albo wyodrębnij konkretne strony online za darmo. Wybierz zakresy stron, np. 1-3, 5. Bez wysyłania, znaku wodnego, rejestracji.',
        'h1' => 'Podziel PDF i wyodrębnij strony',
        'tagline' => 'Wyodrębnij strony albo podziel PDF na osobne pliki - prywatnie w przeglądarce.',
        'keywords' => ['podziel pdf', 'wyodrębnij strony z pdf', 'rozdzielanie stron pdf', 'dzielenie pdf', 'podziel pdf online'],
        'intro' => 'Podział PDF oznacza wyjęcie stron z dokumentu albo podzielenie go na kilka mniejszych plików PDF. Wyciągnij tylko potrzebne strony z PDF-a albo podziel go na osobne pliki. Wpisz zakresy stron, takie jak 1-3, 5, 8-10, albo podziel każdą stronę na własny plik PDF. Przetwarzanie odbywa się całkowicie w Twojej przeglądarce.',
        'steps' => [
            'Wybierz plik PDF, który chcesz podzielić.',
            'Wybierz tryb: wyodrębnij strony do jednego PDF-a, podziel według zakresów albo podziel każdą stronę.',
            'Wpisz zakresy stron, na przykład 1-3, 5, 8-10.',
            'Kliknij Podziel PDF i pobierz wynik (wiele plików przychodzi jako ZIP).',
        ],
        'features' => [
            'Wyodrębnij wybrane strony do nowego PDF-a',
            'Podziel na osobne pliki według własnych zakresów',
            'Podziel każdą stronę na własny plik PDF',
            'Wiele plików jest pakowanych w ZIP',
            'Bez znaku wodnego, bez wysyłania',
        ],
        'content' => [
            [
                'heading' => 'Jak zapisywać zakresy stron',
                'body' => 'Rozdziel zakresy przecinkami. Użyj myślnika dla zakresu stron, na przykład 1-5, albo pojedynczej liczby dla jednej strony. Na przykład „1-3, 7, 10-12” wybiera strony 1, 2, 3, 7, 10, 11 i 12.',
            ],
        ],
        'faqs' => [
            ['q' => 'Jak wyodrębnić jedną stronę z PDF?', 'a' => 'Wybierz „Wyodrębnij strony”, wpisz numer strony (na przykład 4) i kliknij Podziel PDF. Otrzymasz nowy plik PDF zawierający tylko tę stronę.'],
            ['q' => 'Czy mogę podzielić każdą stronę na osobny plik?', 'a' => 'Tak. Wybierz „Podziel każdą stronę” i otrzymasz plik ZIP z jednym PDF-em na każdą stronę.'],
            ['q' => 'Czy moje pliki są wysyłane?', 'a' => 'Nie. PDF jest dzielony lokalnie w Twojej przeglądarce i nigdy nie opuszcza Twojego urządzenia.'],
            ['q' => 'Czy podział zmniejsza jakość?', 'a' => 'Nie. Strony są kopiowane dokładnie tak, jak są, więc tekst i obrazy zachowują oryginalną jakość.'],
        ],
    ],

    'age-calculator' => [
        'name' => 'Kalkulator wieku',
        'title' => 'Kalkulator wieku: wiek w latach, miesiącach i dniach',
        'description' => 'Oblicz swój dokładny wiek w latach, miesiącach, dniach i godzinach na podstawie daty urodzenia, plus odliczanie do urodzin. Darmowy i szybki.',
        'h1' => 'Kalkulator wieku',
        'tagline' => 'Sprawdź dokładny wiek w latach, miesiącach i dniach, plus kolejne urodziny.',
        'keywords' => ['kalkulator wieku', 'oblicz wiek', 'kalkulator daty urodzenia', 'ile mam lat', 'kalkulator wieku z daty urodzenia'],
        'intro' => 'Kalkulator wieku dokładnie wylicza, ile lat, miesięcy i dni ma dana osoba na podstawie daty urodzenia. Wpisz datę urodzenia, aby znaleźć dokładny wiek w latach, miesiącach i dniach. Otrzymasz też łączną liczbę przeżytych miesięcy, tygodni, dni i godzin, dzień tygodnia Twoich urodzin oraz odliczanie do kolejnych urodzin. Możesz też obliczyć wiek na dowolną datę w przeszłości lub przyszłości.',
        'steps' => [
            'Wpisz datę urodzenia.',
            'Zostaw dzisiejszą datę jako datę „wiek w dniu” albo wybierz inną.',
            'Zobacz dokładny wiek i szczegóły natychmiast.',
        ],
        'features' => [
            'Dokładny wiek w latach, miesiącach i dniach',
            'Łączna liczba miesięcy, tygodni, dni i godzin',
            'Odliczanie do kolejnych urodzin',
            'Dzień tygodnia Twoich urodzin',
            'Obsługuje lata przestępne i urodziny 29 lutego',
        ],
        'content' => [
            [
                'heading' => 'Jak liczony jest wiek',
                'body' => 'Kalkulator najpierw liczy pełne lata, potem pełne miesiące, a następnie pozostałe dni, czyli tę samą metodę używaną w dokumentach urzędowych. Lata przestępne są obsługiwane automatycznie, a osoby urodzone 29 lutego obchodzą urodziny 28 lutego w latach nieprzestępnych.',
            ],
        ],
        'faqs' => [
            ['q' => 'Jak obliczyć swój dokładny wiek?', 'a' => 'Wpisz swoją datę urodzenia, a kalkulator pokaże Twój wiek w latach, miesiącach i dniach na dzień dzisiejszy albo na wybraną datę.'],
            ['q' => 'Czy mogę obliczyć wiek na konkretną datę?', 'a' => 'Tak. Zmień datę „wiek w dniu”, aby zobaczyć, ile lat ktoś miał albo będzie miał tego dnia, co jest przydatne w przypadku naboru do szkół i uprawnień do egzaminów.'],
            ['q' => 'Jak traktowane są lata przestępne?', 'a' => 'Lata przestępne są liczone dokładnie. Dla urodzin 29 lutego kolejne urodziny w roku nieprzestępnym są pokazywane jako 28 lutego.'],
            ['q' => 'Czy moja data urodzenia jest zapisywana?', 'a' => 'Nie. Obliczenia odbywają się w Twojej przeglądarce i nic nie jest zapisywane ani wysyłane.'],
        ],
    ],

    'percentage-calculator' => [
        'name' => 'Kalkulator procentowy',
        'title' => 'Kalkulator procentowy - procent, zmiana i wzrost',
        'description' => 'Darmowy kalkulator procentowy: znajdź X% z Y, jaki procent X stanowi Y, wzrost lub spadek procentowy oraz dodaj lub odejmij procent. Pokazuje wzór.',
        'h1' => 'Kalkulator procentowy',
        'tagline' => 'Każde popularne obliczenie procentowe w jednym miejscu, z pokazanym wzorem.',
        'keywords' => ['kalkulator procentowy', 'kalkulator procentów', 'kalkulator zmiany procentowej', 'kalkulator wzrostu procentowego', 'jaki procent z'],
        'intro' => 'Kalkulator procentowy wylicza wartości procentowe, na przykład X% z Y albo zmianę procentową między dwiema liczbami. Szybko oblicz procenty: ile wynosi 15% z 200, jaki procent 120 stanowi 30, wzrost procentowy z 80 do 100 i więcej. Każdy kalkulator pokazuje użyty wzór, dzięki czemu możesz sprawdzić obliczenia do zadania domowego, rabatów, napiwków, ocen i raportów biznesowych.',
        'steps' => [
            'Znajdź kalkulator odpowiadający Twojemu pytaniu.',
            'Wpisz swoje liczby do pól.',
            'Przeczytaj wynik i wzór pod nim.',
        ],
        'features' => [
            'Ile wynosi X% z Y',
            'Jaki procent Y stanowi X',
            'Wzrost lub spadek procentowy z X do Y',
            'X to Y% jakiej liczby',
            'Zwiększ albo zmniejsz liczbę o procent',
            'Wzór pokazany dla każdej odpowiedzi',
        ],
        'content' => [
            [
                'heading' => 'Jaki jest wzór na procent?',
                'body' => 'X% z Y = (X / 100) x Y. X jako procent Y = (X / Y) x 100. Zmiana procentowa z A do B = ((B - A) / |A|) x 100. Dodatni wynik to wzrost, a ujemny to spadek.',
            ],
        ],
        'faqs' => [
            ['q' => 'Jak obliczyć procent z liczby?', 'a' => 'Podziel procent przez 100 i pomnóż przez liczbę. Na przykład 15% z 200 = 0,15 x 200 = 30.'],
            ['q' => 'Jak obliczyć wzrost procentowy?', 'a' => 'Odejmij starą wartość od nowej, podziel przez starą wartość i pomnóż przez 100. Z 80 do 100: (100 - 80) / 80 x 100 = 25%.'],
            ['q' => 'Jak obliczyć rabat?', 'a' => 'Użyj „Zmniejsz liczbę o procent”. Dla rabatu 20% na 50 zł, cena po rabacie to 50 zł x (1 - 0,20) = 40 zł.'],
            ['q' => 'Czemu nie mogę obliczyć zmiany od zera?', 'a' => 'Zmiana procentowa dzieli przez wartość początkową, a dzielenie przez zero jest niezdefiniowane, więc zmiany od 0 nie da się wyrazić procentowo.'],
        ],
        'related' => ['age-calculator', 'tip-calculator', 'word-counter'],
        'table' => [
            'caption' => 'Wzory procentowe z przykładami',
            'headers' => ['Pytanie', 'Wzór', 'Przykład'],
            'rows' => [
                ['Ile to X% z Y?', '(X / 100) × Y', '15% z 200 = 30'],
                ['X to ile % z Y?', '(X / Y) × 100', '30 z 120 = 25%'],
                ['% zmiany z A do B', '(B − A) / |A| × 100', '80 → 100 = +25%'],
                ['Zwiększ Y o X%', 'Y × (1 + X / 100)', '50 + 20% = 60'],
                ['Zmniejsz Y o X%', 'Y × (1 − X / 100)', '50 − 20% = 40'],
            ],
        ],
    ],

    'tip-calculator' => [
        'name' => 'Kalkulator napiwków',
        'title' => 'Kalkulator napiwków - podziel rachunek i napiwek',
        'description' => 'Darmowy kalkulator napiwków: wpisz rachunek, wybierz procent napiwku i podziel sumę między osoby. Zobacz napiwek i sumę na osobę od razu.',
        'h1' => 'Kalkulator napiwków',
        'tagline' => 'Oblicz napiwek i podziel rachunek między dowolną liczbę osób.',
        'keywords' => ['kalkulator napiwków', 'dzielenie rachunku', 'jak obliczyć napiwek', 'kalkulator procentu napiwku', 'kalkulator napiwku w restauracji', 'kalkulator podziału rachunku'],
        'intro' => 'Kalkulator napiwków wylicza, ile dać napiwku na rachunku, i dzieli napiwek oraz sumę równo między dowolną liczbę osób. Wpisz kwotę rachunku, wybierz procent napiwku (popularne szablony to 15%, 18%, 20% i 25%, albo wpisz własny) oraz liczbę osób dzielących rachunek. Kalkulator natychmiast pokazuje napiwek, sumę z napiwkiem i to, co każda osoba powinna zapłacić, z opcją zaokrąglenia kwoty na osobę do pełnej jednostki, aby nikt nie musiał szukać drobnych.',
        'steps' => [
            'Wpisz kwotę rachunku przed napiwkiem.',
            'Wybierz gotowy procent napiwku albo wpisz swój własny.',
            'Ustaw liczbę osób dzielących rachunek (zostaw 1, jeśli nikt nie dzieli).',
            'Włącz „Zaokrąglenie”, jeśli chcesz, żeby każda osoba płaciła pełną kwotę.',
            'Przeczytaj napiwek, sumę i kwoty na osobę poniżej.',
        ],
        'features' => [
            'Gotowe procenty napiwku (15%, 18%, 20%, 25%) plus każdy własny procent',
            'Dzieli napiwek i sumę równo między dowolną liczbę osób',
            'Opcjonalne zaokrąglenie, aby kwota na osobę była pełna',
            'Pokazuje matematykę za każdym wynikiem',
            'Działa całkowicie w Twojej przeglądarce - nic, co wpiszesz, nie jest nigdzie wysyłane',
        ],
        'content' => [
            [
                'heading' => 'Ile napiwku dać?',
                'body' => 'W Stanach Zjednoczonych 15-20% rachunku to najczęściej stosowany zakres napiwku w restauracjach, przy czym 20% jest zwykle stosowane za dobrą obsługę, 15% za przeciętną, a 10% lub mniej za słabą. Dostawa, taksówki i salony stosują zwykle niższe procenty, często 10-15%. Odpowiednia kwota zawsze zależy od lokalnych zwyczajów i otrzymanej obsługi, więc gotowe przyciski są punktem wyjścia, a nie regułą.',
            ],
            [
                'heading' => 'Podział rachunku między grupę',
                'body' => 'Ustawienie „Liczby osób” na więcej niż jeden dzieli równo napiwek i sumę, co jest najprostszym sposobem podziału wspólnego rachunku. Nie uwzględnia to osób zamawiających różne kwoty; w takim przypadku najpierw podziel pozycje każdej osoby i użyj tego kalkulatora tylko do napiwku, który naprawdę trzeba podzielić równo, na przykład wspólnej przystawki.',
            ],
        ],
        'faqs' => [
            ['q' => 'Ile napiwku dać w restauracji?', 'a' => 'W USA 15-20% rachunku przed podatkiem to najczęstszy zakres, przy czym 20% jest typowe za dobrą obsługę. Użyj gotowego przycisku albo wpisz własny procent.'],
            ['q' => 'Czy dajesz napiwek od kwoty przed czy po podatku?', 'a' => 'Większość poradników savoir-vivre sugeruje napiwek od kwoty przed podatkiem, choć napiwek od kwoty po podatku jest też powszechny i dodaje tylko niewielką różnicę.'],
            ['q' => 'Jak podzielić rachunek między przyjaciół?', 'a' => 'Wpisz rachunek i procent napiwku, a potem ustaw „Liczbę osób” na tyle osób, ile go dzieli. Napiwek i suma są dzielone między nie równo.'],
            ['q' => 'Co robi „Zaokrąglenie”?', 'a' => 'Zaokrągla kwotę, którą płaci każda osoba, do pełnej jednostki, aby nikt nie musiał szukać drobnych. Dodatkowe grosze są dodawane do napiwku.'],
            ['q' => 'Czy ten kalkulator napiwków jest darmowy?', 'a' => 'Tak. Jest darmowy, bez rejestracji, a wszystko jest obliczane w Twojej przeglądarce.'],
        ],
        'table' => [
            'caption' => 'Wysokość napiwku na rachunku 200 zł',
            'headers' => ['Napiwek %', 'Kwota napiwku', 'Suma z napiwkiem'],
            'rows' => [
                ['15%', '30 zł', '230 zł'],
                ['18%', '36 zł', '236 zł'],
                ['20%', '40 zł', '240 zł'],
                ['25%', '50 zł', '250 zł'],
            ],
        ],
    ],

    'json-formatter' => [
        'name' => 'Formatter JSON',
        'title' => 'Formatter JSON - formatuj i waliduj JSON online',
        'description' => 'Formatuj, upiększaj, waliduj i minifikuj JSON online za darmo. Znajduje błędy z numerem wiersza i kolumny. Szybki, prywatny formatter dla programistów.',
        'h1' => 'Formatter i walidator JSON',
        'tagline' => 'Upiększaj, waliduj i minifikuj JSON z czytelnymi komunikatami o błędach.',
        'keywords' => ['formatter json', 'walidator json', 'upiększanie json', 'formatowanie json', 'minifikacja json'],
        'intro' => 'Formatter JSON to narzędzie, które sprawia, że dane JSON są czytelne, dodając podziały wierszy i wcięcia, oraz sprawdza, czy są prawidłowe. Wklej JSON, aby go upiększyć z czystymi wcięciami, zwalidować albo zminifikować na potrzeby produkcji. Jeśli JSON jest nieprawidłowy, otrzymasz czytelny komunikat błędu z dokładnym wierszem i kolumną, dzięki czemu naprawisz go szybko. Twoje dane są przetwarzane lokalnie i nigdy nie są nigdzie wysyłane.',
        'steps' => [
            'Wklej swój JSON do pola wejściowego albo kliknij Przykład.',
            'Kliknij Formatuj, aby upiększyć, albo Minifikuj, aby skompresować.',
            'Naprawiaj błędy, korzystając z pokazanego wiersza i kolumny.',
            'Skopiuj albo pobierz wynik.',
        ],
        'features' => [
            'Upiększanie z 2 spacjami, 4 spacjami albo tabulatorami',
            'Minifikacja JSON do jednego wiersza',
            'Walidacja z wierszem i kolumną błędu',
            'Opcjonalne sortowanie kluczy alfabetycznie',
            'Kopiowanie i pobieranie jako .json',
        ],
        'content' => [
            [
                'heading' => 'Jakie są najczęstsze błędy JSON?',
                'body' => 'Najczęstsze błędy to nadmiarowe przecinki po ostatnim elemencie, pojedyncze cudzysłowy zamiast podwójnych, klucze bez cudzysłowów i komentarze, z których żaden nie jest dopuszczony w standardowym JSON.',
            ],
        ],
        'faqs' => [
            ['q' => 'Czy mój JSON jest wysyłany na serwer?', 'a' => 'Nie. Formatowanie i walidacja odbywają się w Twojej przeglądarce, więc klucze API i prywatne dane zostają na Twoim urządzeniu.'],
            ['q' => 'Jaka jest różnica między formatowaniem i minifikacją?', 'a' => 'Formatowanie dodaje podziały wierszy i wcięcia, aby JSON był czytelny. Minifikacja usuwa wszystkie niepotrzebne odstępy, aby plik był jak najmniejszy.'],
            ['q' => 'Czemu mój JSON pokazuje błąd?', 'a' => 'Sprawdź wiersz i kolumnę w komunikacie. Nadmiarowe przecinki, pojedyncze cudzysłowy i brakujące cudzysłowy wokół kluczy to zwykłe przyczyny.'],
            ['q' => 'Czy obsługuje duże pliki?', 'a' => 'Tak. Pliki o rozmiarze kilku megabajtów formatują się w mniej niż sekundę na większości urządzeń.'],
        ],
        'table' => [
            'caption' => 'Częste błędy JSON i jak je naprawić',
            'headers' => ['Problem', 'Nieprawidłowe', 'Prawidłowe'],
            'rows' => [
                ['Nadmiarowy przecinek', '{"a": 1,}', '{"a": 1}'],
                ['Pojedyncze cudzysłowy', '{\'a\': 1}', '{"a": 1}'],
                ['Klucz bez cudzysłowów', '{a: 1}', '{"a": 1}'],
                ['Komentarz', '{"a": 1 // uwaga}', '{"a": 1}'],
            ],
        ],
    ],

    'base64-encoder-decoder' => [
        'name' => 'Kodowanie / dekodowanie Base64',
        'title' => 'Base64 online - kodowanie i dekodowanie tekstu i plików',
        'description' => 'Zakoduj tekst lub plik do Base64 i zdekoduj Base64 z powrotem na tekst online. Pełna obsługa UTF-8 i wariantu bezpiecznego dla URL. Darmowy konwerter.',
        'h1' => 'Koder i dekoder Base64',
        'tagline' => 'Koduj i dekoduj tekst i pliki Base64, z obsługą UTF-8 i wariantu bezpiecznego dla URL.',
        'keywords' => ['kodowanie base64', 'dekodowanie base64', 'konwerter base64', 'base64 na tekst', 'obraz do base64'],
        'intro' => 'Base64 to sposób zapisu dowolnych danych, w tym plików, za pomocą tylko 64 znaków tekstowych; kodowanie zmienia dane na Base64, a dekodowanie zmienia je z powrotem. Zamień tekst na Base64 albo zdekoduj Base64 z powrotem na czytelny tekst, z pełną obsługą emoji i znaków innych niż angielskie. Możesz też zamienić plik albo obraz na data URL w Base64 do wstawienia w HTML, CSS albo JSON.',
        'steps' => [
            'Wybierz tryb Tekst albo Plik.',
            'Dla tekstu wklej swoje dane i kliknij Koduj albo Dekoduj.',
            'Dla plików wybierz plik, aby otrzymać jego ciąg Base64 albo data URL.',
            'Skopiuj wynik.',
        ],
        'features' => [
            'Kodowanie i dekodowanie tekstu z pełną obsługą UTF-8',
            'Opcja Base64 bezpiecznego dla URL (- i _ zamiast + i /)',
            'Plik i obraz do Base64 albo data URL',
            'Czytelny komunikat błędu dla nieprawidłowego Base64',
            'Działa lokalnie - nic nie jest wysyłane',
        ],
        'content' => [
            [
                'heading' => 'Co to jest Base64?',
                'body' => 'Base64 przedstawia dane binarne za pomocą 64 bezpiecznych znaków tekstowych (A-Z, a-z, 0-9, + i /). Jest używany do wstawiania obrazów w HTML i CSS, wysyłania załączników e-mailem oraz przekazywania danych w adresach URL i API. Base64 jest kodowaniem, a nie szyfrowaniem, więc nie utrzymuje danych w tajemnicy.',
            ],
        ],
        'faqs' => [
            ['q' => 'Czy Base64 to szyfrowanie?', 'a' => 'Nie. Każdy może zdekodować Base64. Używaj go do przesyłania danych, nigdy do ochrony haseł albo tajnych informacji.'],
            ['q' => 'Co to jest Base64 bezpieczny dla URL?', 'a' => 'Wariant, który zamienia + na - a / na _, i zwykle pomija dopełnienie =, dzięki czemu ciąg można bezpiecznie używać w adresach URL i nazwach plików.'],
            ['q' => 'Czemu Base64 jest większy niż oryginał?', 'a' => 'Base64 zamienia każde 3 bajty na 4 znaki, więc zakodowane dane są o około 33% większe niż oryginał.'],
            ['q' => 'Jak przekonwertować obraz na Base64?', 'a' => 'Przełącz się na tryb Plik i wybierz swój obraz. Otrzymasz zarówno surowy ciąg Base64, jak i gotowy do użycia data URL.'],
        ],
        'table' => [
            'caption' => 'O ile Base64 zwiększa rozmiar danych',
            'headers' => ['Rozmiar oryginalny', 'Długość Base64'],
            'rows' => [
                ['3 bajty', '4 znaki'],
                ['1 KB (1024 bajty)', '1368 znaków'],
                ['1 MB (1 048 576 bajtów)', '1 398 104 znaki'],
            ],
        ],
    ],

    'what-is-my-ip' => [
        'name' => 'Jaki jest mój adres IP',
        'title' => 'Jaki jest mój adres IP? Sprawdź publiczne IP natychmiast',
        'description' => 'Zobacz swój publiczny adres IP natychmiast, sprawdź, czy to IPv4 czy IPv6, oraz informacje o przeglądarce, systemie, rozmiarze ekranu i strefie czasowej.',
        'h1' => 'Jaki jest mój adres IP?',
        'tagline' => 'Twój publiczny adres IP i dane o przeglądarce, natychmiast.',
        'keywords' => ['jaki jest mój ip', 'mój adres ip', 'sprawdzanie adresu ip', 'sprawdź moje ip', 'jaki jest mój adres ip'],
        'intro' => 'Adres IP to numer identyfikujący Twoje połączenie w internecie; Twój publiczny adres IP to ten, który widzą strony internetowe. Twój publiczny adres IP to adres, który widzą strony, gdy łączysz się z internetem. Przypisuje go Twój dostawca internetu albo Twoje VPN, jeśli go używasz. Poniżej zobaczysz swój aktualny adres IP, czy to IPv4 czy IPv6, oraz szczegóły o przeglądarce i urządzeniu.',
        'steps' => [
            'Otwórz tę stronę - Twój adres IP jest pokazany na górze.',
            'Kliknij Kopiuj, aby skopiować go do schowka.',
            'Włącz albo wyłącz VPN i kliknij Odśwież, aby zobaczyć zmianę swojego IP.',
        ],
        'features' => [
            'Publiczny adres IP z kopiowaniem jednym kliknięciem',
            'Wykrywanie IPv4 albo IPv6',
            'Przeglądarka, system operacyjny i typ urządzenia',
            'Rozdzielczość ekranu, język i strefa czasowa',
            'Odświeżenie, aby sprawdzić, że VPN działa',
        ],
        'content' => [
            [
                'heading' => 'IPv4 a IPv6',
                'body' => 'Adresy IPv4 wyglądają jak 203.0.113.42 i jest ich tylko około 4,3 miliarda. Adresy IPv6, takie jak 2001:db8::1, zostały wprowadzone, bo adresy IPv4 się wyczerpały. Wiele połączeń wspiera już oba.',
            ],
            [
                'heading' => 'Publiczny a prywatny adres IP',
                'body' => 'Twój router przypisuje każdemu urządzeniu w domu prywatny adres IP (często 192.168.x.x). Cała sieć dzieli jeden publiczny adres IP w internecie, który jest pokazany na tej stronie.',
            ],
        ],
        'faqs' => [
            ['q' => 'Do czego służy mój adres IP?', 'a' => 'Strony i usługi używają Twojego adresu IP, aby wysłać Ci dane z powrotem. Może też zdradzać Twoje przybliżone miasto i dostawcę internetu.'],
            ['q' => 'Czemu mój adres IP się zmienia?', 'a' => 'Większość domowych dostawców internetu przypisuje dynamiczne adresy IP, które mogą się zmienić po ponownym uruchomieniu routera. Adresy IP w internecie mobilnym zmieniają się często.'],
            ['q' => 'Jak mogę ukryć swój adres IP?', 'a' => 'Użyj VPN albo sieci prywatności, takiej jak Tor. Strony wtedy widzą adres IP VPN, a nie Twój.'],
            ['q' => 'Czy zapisujecie mój adres IP?', 'a' => 'Nie. To narzędzie tylko wyświetla Twój adres IP Tobie i nie zapisuje go w żadnej bazie danych.'],
            ['q' => 'Jak sprawdzić mój publiczny adres IPv4?', 'a' => 'Po prostu otwórz tę stronę – Twój publiczny adres IP pojawi się u góry natychmiast, bez rejestracji i dodatkowych kliknięć. Większość domowych i mobilnych połączeń korzysta z IPv4; jeśli Twoje łącze używa IPv6, strona pokaże ten adres.'],
        ],
    ],

    'dice-roller' => [
        'name' => 'Rzut kością',
        'title' => 'Rzut kością online - wirtualne kości (K6, K20 i więcej)',
        'description' => 'Rzuć od 1 do 10 wirtualnymi kośćmi online: K4, K6, K8, K10, K12 albo K100. Sprawiedliwe, losowe wyniki z animacją 3D, sumami i historią rzutów. Darmowe.',
        'h1' => 'Rzut kością',
        'tagline' => 'Rzuć do 10 kośćmi, od K4 do K100, z animacją 3D i sumami.',
        'keywords' => ['rzut kością', 'rzut kością online', 'wirtualna kość', 'rzucanie k20', 'losowa kość'],
        'intro' => 'Rzut kością to narzędzie online, które symuluje rzucanie kostkami i daje losowy wynik dla każdej z nich. Zgubiłeś kości do gry planszowej albo potrzebujesz K20 do RPG? Ten darmowy rzut kością rzuca jednocześnie do dziesięciu wirtualnymi kośćmi z realistyczną animacją 3D. Wybierz standardową kostkę sześcienną albo każdą kość wielościenną od K4 do K100 i zobacz każdą wartość, sumę i swoje ostatnie rzuty natychmiast.',
        'steps' => [
            'Wybierz typ kości: K4, K6, K8, K10, K12, K20 albo K100.',
            'Wybierz, ile kości rzucić, od 1 do 10.',
            'Naciśnij Rzuć (albo dotknij kości, albo wciśnij R na klawiaturze).',
            'Przeczytaj każdą wartość i sumę. Wcześniejsze rzuty zostają na liście historii.',
        ],
        'features' => [
            'Siedem typów kości: K4, K6, K8, K10, K12, K20 i K100',
            'Rzut do 10 kośćmi na raz z automatyczną sumą',
            'Obracające się w 3D sześciostronne kości z prawdziwym układem oczek',
            'Sprawiedliwe wyniki z bezpiecznego generatora liczb losowych przeglądarki',
            'Historia rzutów i skróty klawiaturowe (R, Spacja albo Enter)',
        ],
        'content' => [
            [
                'heading' => 'Czy wirtualny rzut kością jest sprawiedliwy?',
                'body' => 'Tak. Każdy rzut korzysta z wbudowanego w przeglądarkę Web Crypto API, tego samego źródła losowości, które służy do tworzenia haseł i kluczy szyfrujących. Każda strona ma dokładnie taką samą szansę wypadnięcia, a wynik jest ustalany przed rozpoczęciem animacji, więc animacja nie może na niego wpłynąć. Dla porównania, prawdziwe kości mogą być nieco niezbalansowane przez zaokrąglone krawędzie albo wywiercone oczka.',
            ],
            [
                'heading' => 'Jakich kości używają gry?',
                'body' => 'Większość rodzinnych gier planszowych, takich jak Monopoly, Chińczyk czy Yahtzee, używa kości sześciennych (K6). Gry RPG, jak Dungeons & Dragons, używają pełnego zestawu kości wielościennych: K4, K6, K8, K10, K12 i K20, z dwoma K10 albo K100 do rzutów procentowych. Możesz przełączać się między nimi tutaj jednym kliknięciem.',
            ],
        ],
        'faqs' => [
            ['q' => 'Ile kości mogę rzucić jednocześnie?', 'a' => 'Możesz rzucić od 1 do 10 kości na raz. Rzut kością pokazuje każdą wartość i sam dodaje sumę.'],
            ['q' => 'Czy rzuty kością są naprawdę losowe?', 'a' => 'Tak. Rzuty korzystają z kryptograficznie bezpiecznego generatora liczb losowych Twojej przeglądarki, więc każda strona jest równie prawdopodobna, a wyników nie można przewidzieć.'],
            ['q' => 'Czy mogę rzucić K20 do Dungeons & Dragons?', 'a' => 'Tak. Wybierz K20 z typów kości i naciśnij Rzuć. Dostępne są też K4, K8, K10, K12 i K100.'],
            ['q' => 'Czy mogę używać rzutu kością bez animacji?', 'a' => 'Jeśli Twoje urządzenie ma ustawione ograniczenie animacji, wyniki pojawiają się natychmiast bez animacji rzutu.'],
            ['q' => 'Co to jest generator kości online?', 'a' => 'Generator kości online (czyli rzut kością) zastępuje fizyczne kości symulowanym rzutem na ekranie: wybierasz typ kości i ich liczbę, a każdy rzut natychmiast pokazuje sprawiedliwy, losowy wynik, bez niczego do rzucania czy podnoszenia.'],
        ],
        'table' => [
            'caption' => 'Typy kości i ich zastosowanie',
            'headers' => ['Kość', 'Ścianki', 'Typowe zastosowanie'],
            'rows' => [
                ['K4', '4', 'Małe rzuty na obrażenia w grach RPG'],
                ['K6', '6', 'Gry planszowe, takie jak Monopoly i Chińczyk'],
                ['K8, K10, K12', '8, 10, 12', 'Rzuty na obrażenia i umiejętności w grach RPG'],
                ['K20', '20', 'Rzuty na atak i testy w Dungeons & Dragons'],
                ['K100', '100', 'Rzuty procentowe'],
            ],
        ],
    ],

    'coin-flip' => [
        'name' => 'Rzut monetą',
        'title' => 'Rzut monetą online - orzeł czy reszka?',
        'description' => 'Rzuć monetą online na orła czy reszkę z realistyczną animacją 3D. Rzuć do 100 monet na raz i śledź sumy oraz serie. Sprawiedliwe, darmowe i natychmiastowe.',
        'h1' => 'Rzuć monetą',
        'tagline' => 'Orzeł czy reszka? Podrzuć monetę 3D albo rzuć do 100 na raz i zobacz statystyki.',
        'keywords' => ['rzut monetą', 'podrzuć monetę', 'orzeł czy reszka', 'rzut monetą online', 'wirtualna moneta'],
        'intro' => 'Rzut monetą to szybki sposób wyboru między dwiema opcjami losowo: orzeł czy reszka, każda z szansą 50%. Rozstrzygnij decyzję, wybierz, kto zaczyna, albo przeprowadź eksperyment z prawdopodobieństwem za pomocą tego darmowego rzutu monetą online. Podrzuć jedną monetę 3D, która obraca się w powietrzu, albo rzuć do 100 monet na raz. Narzędzie liczy orły i reszki na bieżąco, pokazuje podział procentowy i Twoją aktualną serię.',
        'steps' => [
            'Wybierz, ile monet rzucić: 1, 2, 5, 10, 25 albo 100.',
            'Naciśnij Rzuć (albo dotknij monety, albo wciśnij F).',
            'Zobacz wynik, bieżące sumy, podział orły/reszki i swoją serię.',
            'Naciśnij Resetuj statystyki, aby zacząć nowy eksperyment.',
        ],
        'features' => [
            'Realistyczna animacja 3D rzutu monetą',
            'Rzut do 100 monet za jednym razem',
            'Bieżące sumy, podział procentowy i aktualna seria',
            'Dokładnie 50/50 szans dzięki bezpiecznej losowości',
            'Skrót klawiaturowy: F, Spacja albo Enter',
        ],
        'content' => [
            [
                'heading' => 'Czy rzut monetą jest naprawdę 50/50?',
                'body' => 'Wirtualny rzut monetą tutaj jest dokładnie 50/50: każdy wynik pochodzi z bezpiecznego generatora liczb losowych Twojej przeglądarki, bez pamięci wcześniejszych rzutów. Prawdziwe monety są bardzo nieznacznie obciążone na stronę, która była górą przed podrzuceniem, co badacze zmierzyli na około 51%. Serie pięciu czy sześciu takich samych wyników są normalne i nie oznaczają, że moneta jest nieuczciwa.',
            ],
            [
                'heading' => 'Zabawne sposoby wykorzystania rzutu monetą',
                'body' => 'Rzuty monetą służą do decydowania, kto zaczyna mecz, do rozstrzygania remisów, do szybkich decyzji tak albo nie i do nauki prawdopodobieństwa w szkołach. Rzuć 100 monetami na raz, aby zobaczyć w praktyce prawo wielkich liczb: im więcej rzutów wykonasz, tym bliżej podział jest 50%.',
            ],
        ],
        'faqs' => [
            ['q' => 'Czy ten rzut monetą jest sprawiedliwy?', 'a' => 'Tak. Każdy rzut ma dokładnie 50% szans na orła i 50% na reszkę, generowane przez kryptograficznie bezpieczną losowość Twojej przeglądarki.'],
            ['q' => 'Czy mogę rzucić więcej niż jedną monetą?', 'a' => 'Tak. Wybierz 2, 5, 10, 25 albo 100 monet, a wszystkie zostaną rzucone na raz, z liczbą orłów i reszek.'],
            ['q' => 'Czemu wypadł mi orzeł pięć razy z rzędu?', 'a' => 'Serie są normalną częścią losowości. Szansa na pięć orłów z rzędu wynosi około 3%, więc zdarza się to regularnie przy wielu rzutach.'],
            ['q' => 'Czy narzędzie zapisuje moje wyniki?', 'a' => 'Sumy i Twoja seria są zachowywane, póki strona jest otwarta. Nic nie jest wysyłane na serwer, a Resetuj statystyki je czyści.'],
            ['q' => 'Czy to tak jak poprosić asystenta głosowego o rzut monetą?', 'a' => 'Tak: otrzymujesz ten sam sprawiedliwy wynik 50/50 jak przy prośbie do asystenta głosowego, ale tutaj widzisz realistyczną animację 3D, możesz rzucić do 100 monet na raz, a gra liczy orły, reszki i Twoją serię.'],
        ],
    ],

    'spin-the-wheel' => [
        'name' => 'Koło losujące',
        'title' => 'Koło losujące - wybór losowego imienia i opcji',
        'description' => 'Zakręć kołem, aby wylosować imię, zwycięzcę albo opcję. Dodaj do 100 pozycji, zakręć z płynną animacją i usuwaj zwycięzców na bieżąco. Darmowe koło.',
        'h1' => 'Koło losujące',
        'tagline' => 'Dodaj imiona albo opcje, zakręć i pozwól kołu wylosować zwycięzcę.',
        'keywords' => ['koło losujące', 'losujące koło', 'losowanie imienia', 'koło imion', 'losowy wybór'],
        'intro' => 'Koło losujące to losowy wybieracz: dodajesz imiona albo opcje, zakręcasz, a koło zatrzymuje się na jednym z nich losowo. Nie możesz się zdecydować, co zjeść, kto idzie następny, albo kto wygrywa konkurs? Wpisz swoje opcje do listy, jedną w wierszu, i zakręć kołem. Obraca się kilka razy i zwalnia, aż zatrzyma się na losowej pozycji, a potem ogłasza zwycięzcę. Możesz automatycznie usuwać każdego zwycięzcę, aby losować imiona jedno po drugim bez powtórzeń.',
        'steps' => [
            'Wpisz albo wklej swoje pozycje, jedną w wierszu (do 100).',
            'Naciśnij Zakręć, kliknij środek koła albo wciśnij S.',
            'Obserwuj, jak koło zwalnia i zatrzymuje się na zwycięzcy.',
            'Opcjonalnie zaznacz „Usuń zwycięzcę po każdym losowaniu”, aby losować bez powtórzeń.',
        ],
        'features' => [
            'Do 100 pozycji, każda z własnym kolorowym wycinkiem',
            'Płynne losowanie, które zwalnia do zatrzymania, z ogłoszeniem zwycięzcy',
            'Automatyczne albo ręczne usuwanie zwycięzców',
            'Losowe mieszanie kolejności pozycji',
            'Każda pozycja ma dokładnie taką samą szansę na wygraną',
        ],
        'content' => [
            [
                'heading' => 'Jak koło wybiera zwycięzcę',
                'body' => 'Gdy naciskasz Zakręć, zwycięzca jest wybierany najpierw za pomocą bezpiecznego generatora liczb losowych Twojej przeglądarki, co daje każdej pozycji równą szansę niezależnie od długości jej nazwy. Koło następnie wylicza dokładnie, o ile się obrócić, aby wybrany wycinek zatrzymał się pod wskaźnikiem, dodając kilka pełnych obrotów i losowy punkt zatrzymania w wycinku, dzięki czemu każde losowanie wygląda inaczej.',
            ],
            [
                'heading' => 'Pomysły na wykorzystanie koła losującego',
                'body' => 'Nauczyciele używają kół z imionami, aby sprawiedliwie wybierać uczniów, streamerzy i sklepy organizują konkursy, a przyjaciele używają ich, aby zdecydować o restauracji, filmie czy obowiązkach domowych. Włącz „Usuń zwycięzcę po każdym losowaniu”, aby wylosować kolejność, podzielić ludzi na zespoły albo wybrać kilku zwycięzców nagród bez powtórzeń.',
            ],
        ],
        'faqs' => [
            ['q' => 'Czy koło losujące jest losowe?', 'a' => 'Tak. Zwycięzca jest wybierany za pomocą kryptograficznie bezpiecznej losowości, zanim koło się zatrzyma, więc każda pozycja ma równą szansę.'],
            ['q' => 'Ile imion mogę dodać?', 'a' => 'Możesz dodać do 100 pozycji. Umieść każdą w osobnym wierszu.'],
            ['q' => 'Czy mogę usunąć imię po tym, jak wygra?', 'a' => 'Tak. Kliknij przycisk Usuń po losowaniu albo zaznacz „Usuń zwycięzcę po każdym losowaniu”, aby robić to automatycznie.'],
            ['q' => 'Czy moje pozycje są zapisywane albo udostępniane?', 'a' => 'Nie. Twoja lista zostaje w Twojej przeglądarce i nigdy nie jest wysyłana.'],
        ],
    ],

    'random-number-generator' => [
        'name' => 'Generator liczb losowych',
        'title' => 'Generator liczb losowych - wybierz liczby z zakresu',
        'description' => 'Generuj liczby losowe w dowolnym zakresie, jedną lub setki na raz, z duplikatami albo bez. Świetne do loterii, losowań i gier. Darmowe i szybkie.',
        'h1' => 'Generator liczb losowych',
        'tagline' => 'Wybierz liczby losowe w dowolnym zakresie, bez duplikatów, jeśli potrzebujesz.',
        'keywords' => ['generator liczb losowych', 'liczba losowa', 'losowanie liczb', 'generator liczb', 'generator liczb do loterii'],
        'intro' => 'Generator liczb losowych to narzędzie, które wybiera liczby przypadkowo z wybranego przez Ciebie zakresu. Wygeneruj losową liczbę z dowolnego zakresu albo całą ich listę. Wybierz minimum, maksimum i ile liczb potrzebujesz, a potem zdecyduj, czy duplikaty są dozwolone i czy lista powinna być sortowana. Idealny do losowań, loterii, zajęć szkolnych, próbkowania i gier.',
        'steps' => [
            'Wpisz liczbę minimalną i maksymalną (liczby ujemne też działają).',
            'Wybierz, ile liczb chcesz, do 1000.',
            'Zaznacz „Bez duplikatów” i „Sortuj od najmniejszej” jeśli potrzebujesz.',
            'Naciśnij Generuj albo użyj szablonu, takiego jak 1-100 albo 6 z 49.',
        ],
        'features' => [
            'Każdy zakres liczb całkowitych, w tym liczby ujemne',
            'Do 1000 liczb na raz',
            'Tryb bez duplikatów do losowań i loterii',
            'Opcjonalne sortowanie i kopiowanie wyników jednym kliknięciem',
            'Bezpieczna, niezafałszowana losowość z Twojej przeglądarki',
        ],
        'content' => [
            [
                'heading' => 'Jak losowe są te liczby?',
                'body' => 'Liczby pochodzą z Web Crypto API, kryptograficznie bezpiecznego generatora liczb losowych wbudowanego w każdą nowoczesną przeglądarkę. Generator korzysta też z próbkowania odrzucającego, techniki, która usuwa małe obciążenie spotykane w wielu prostych narzędziach losowych, więc każda liczba w Twoim zakresie ma dokładnie takie samo prawdopodobieństwo.',
            ],
            [
                'heading' => 'Wybieranie liczb bez duplikatów',
                'body' => 'Włącz „Bez duplikatów”, gdy każda liczba może się pojawić tylko raz, na przykład przy losowaniu biletów na loterię albo numerów lotto. Narzędzie sprawdza, czy Twój zakres jest wystarczająco duży: nie można wybrać 10 różnych liczb między 1 a 5. Gdy duplikaty są dozwolone, każda liczba jest wybierana niezależnie, jak rzut kością wiele razy.',
            ],
        ],
        'faqs' => [
            ['q' => 'Czy mogę wygenerować losową liczbę od 1 do 100?', 'a' => 'Tak. Ustaw minimum na 1 i maksimum na 100 albo kliknij szablon 1-100, a potem naciśnij Generuj.'],
            ['q' => 'Czy mogę wygenerować liczby lotto?', 'a' => 'Tak. Użyj szablonu „Lotto 6 z 49” albo wybierz własny zakres i liczbę z zaznaczonym „Bez duplikatów”.'],
            ['q' => 'Ile liczb mogę wygenerować na raz?', 'a' => 'Do 1000 liczb za jednym kliknięciem. Możesz skopiować je wszystkie jednym przyciskiem.'],
            ['q' => 'Czy mogę używać liczb ujemnych?', 'a' => 'Tak. Działają wszystkie liczby całkowite, na przykład zakres od -50 do 50.'],
        ],
    ],

    'stopwatch' => [
        'name' => 'Stoper',
        'title' => 'Stoper online - darmowy stoper z czasami okrążeń',
        'description' => 'Darmowy stoper online z dokładnością do 1/100 sekundy, z czasami okrążeń i etapów, najszybszym i najwolniejszym okrążeniem oraz skrótami klawiaturowymi.',
        'h1' => 'Stoper online',
        'tagline' => 'Dokładność do 1/100 sekundy, z okrążeniami, etapami i skrótami klawiaturowymi.',
        'keywords' => ['stoper', 'stoper online', 'stoper z okrążeniami', 'minutnik', 'stoper do okrążeń'],
        'intro' => 'Stoper mierzy, ile czasu upływa między jego uruchomieniem i zatrzymaniem, i może zapisywać czasy okrążeń. Zmierz bieg, prezentację, przepis albo trening za pomocą tego darmowego stopera online. Liczy do setnej sekundy, zapisuje czasy okrążeń i etapów oraz wyróżnia Twoje najszybsze i najwolniejsze okrążenie. Ponieważ mierzy rzeczywisty upływający czas, zachowuje dokładność, nawet gdy przełączysz się na inną kartę.',
        'steps' => [
            'Naciśnij Start (albo spację), aby zacząć pomiar czasu.',
            'Naciśnij Okrążenie (albo L), aby zapisać okrążenie bez zatrzymywania zegara.',
            'Naciśnij Stop, aby zatrzymać, a potem Wznów, aby kontynuować.',
            'Naciśnij Resetuj (albo R), aby wyczyścić czas i okrążenia. Skopiuj okrążenia, aby je gdzieś wkleić.',
        ],
        'features' => [
            'Dokładność do 1/100 sekundy',
            'Nieograniczona liczba okrążeń z czasami okrążenia i łącznymi (etapu)',
            'Wyróżnione najszybsze i najwolniejsze okrążenie',
            'Skróty klawiaturowe: Spacja, L i R',
            'Zachowuje dokładny czas na kartach w tle',
        ],
        'content' => [
            [
                'heading' => 'Jak dokładny jest stoper online?',
                'body' => 'Ten stoper odczytuje precyzyjny zegar Twojego urządzenia przy każdym odświeżeniu ekranu, a nie poprzez liczenie ticków timera, więc małe opóźnienia nigdy się nie kumulują. Przeglądarki zwalniają strony w kartach w tle, ale ponieważ czas, który upłynął, jest zawsze obliczany od momentu startu, odczyt jest wciąż prawidłowy, gdy wrócisz.',
            ],
            [
                'heading' => 'Czas okrążenia a czas etapowy',
                'body' => 'Czas okrążenia to czas, jaki zajęło samo jedno okrążenie, na przykład 1:05 dla trzeciego okrążenia na bieżni. Czas etapowy (albo łączny) to czas od startu, na przykład 3:20, gdy kończy się trzecie okrążenie. Tabela okrążeń pokazuje obydwa, dzięki czemu widzisz swoje tempo i ogólny postęp na pierwszy rzut oka.',
            ],
        ],
        'faqs' => [
            ['q' => 'Czy stoper działa dalej na innej karcie?', 'a' => 'Tak. Mierzy rzeczywisty upływający czas, więc odczyt jest poprawny, nawet gdy karta była w tle.'],
            ['q' => 'Jak zapisać okrążenie?', 'a' => 'Naciśnij Okrążenie, gdy stoper działa, albo wciśnij klawisz L. Każde okrążenie pokazuje swój czas i czas łączny.'],
            ['q' => 'Czy mogę używać klawiatury?', 'a' => 'Tak. Spacja startuje i zatrzymuje, L zapisuje okrążenie, a R resetuje po zatrzymaniu.'],
            ['q' => 'Czy mogę zapisać swoje czasy okrążeń?', 'a' => 'Naciśnij Kopiuj okrążenia, aby skopiować wszystkie czasy okrążeń i łączne, a potem wklej je do arkusza, notatki albo wiadomości.'],
            ['q' => 'Czy stoper to to samo co minutnik?', 'a' => 'Nie. Stoper, taki jak to narzędzie, liczy czas od zera w górę, aby zmierzyć, jak długo coś trwa. Minutnik odlicza czas w dół od ustawionej wartości i na końcu włącza alarm - do tego służy Minutnik.'],
        ],
    ],

    'countdown-timer' => [
        'name' => 'Minutnik',
        'title' => 'Minutnik online - odliczanie czasu z alarmem',
        'description' => 'Ustaw minutnik na sekundy, minuty albo godziny jednym kliknięciem. Alarm włącza się po zakończeniu, a tytuł karty pokazuje pozostały czas. Darmowy minutnik.',
        'h1' => 'Minutnik',
        'tagline' => 'Ustaw minuty albo godziny, albo wybierz szablon. Alarm włącza się po zakończeniu.',
        'keywords' => ['minutnik', 'minutnik online', 'minutnik z alarmem', 'minutnik 5 minut', 'ustaw minutnik'],
        'intro' => 'Minutnik odlicza od ustawionego czasu do zera, a potem włącza alarm. Ustaw minutnik do gotowania, nauki, treningu, spotkania albo egzaminu. Wpisz każdą długość do 99 godzin albo wybierz szablon, taki jak 5 minut czy 25 minut. Pierścień odlicza pozostały czas, karta przeglądarki pokazuje go w tytule, a po dojściu do zera włącza się alarm.',
        'steps' => [
            'Wpisz godziny, minuty i sekundy albo wybierz szablon.',
            'Naciśnij Start (albo spację). Pierścień i tytuł karty odliczają czas.',
            'Wstrzymaj, wznów albo dodaj minutę w każdej chwili.',
            'Gdy alarm się włączy, naciśnij Zatrzymaj alarm, a potem Nowy minutnik, aby zacząć ponownie.',
        ],
        'features' => [
            'Każda długość od 1 sekundy do 99 godzin i 59 minut',
            'Szablony jednym kliknięciem od 30 sekund do 1 godziny',
            'Dźwięk alarmu z opcją wyłączenia',
            'Pozostały czas pokazany w tytule karty przeglądarki',
            'Wstrzymanie, kontynuacja i +1 minuta, ze skrótami klawiaturowymi',
        ],
        'content' => [
            [
                'heading' => 'Czy minutnik działa w karcie w tle?',
                'body' => 'Tak. Minutnik wylicza dokładny moment, w którym powinien się zakończyć, więc zachowuje dokładność nawet, gdy przełączasz karty i przeglądarka zwalnia stronę. Pozostały czas jest też pokazywany w tytule karty, więc możesz go obserwować, pracując na innej karcie. Zostaw kartę otwartą i głośność włączoną, aby usłyszeć alarm.',
            ],
            [
                'heading' => 'Popularne długości minutnika',
                'body' => 'Pięć minut jest idealne do herbaty, krótkich przerw i szybkich ćwiczeń. Dwadzieścia pięć minut to klasyczna sesja skupienia Pomodoro, zwykle po niej pięciominutowa przerwa. Dłuższe minutniki, 30 albo 60 minut, sprawdzają się na egzaminach, spotkaniach i przy pieczeniu. Użyj do tego szablonów albo wpisz inną długość.',
            ],
        ],
        'faqs' => [
            ['q' => 'Czy minutnik wydaje dźwięk?', 'a' => 'Tak. Alarm dzwoni, gdy czas się skończy, do 30 sekund albo aż naciśniesz Zatrzymaj alarm. Możesz wyłączyć dźwięk.'],
            ['q' => 'Czemu nie usłyszałem alarmu?', 'a' => 'Sprawdź, czy głośność jest włączona i karta wciąż otwarta. Przeglądarki zezwalają na dźwięk tylko po kliknięciu na stronę, co dzieje się, gdy naciskasz Start.'],
            ['q' => 'Jaki jest najdłuższy minutnik, jaki mogę ustawić?', 'a' => 'Do 99 godzin, 59 minut i 59 sekund.'],
            ['q' => 'Czy mogę wstrzymać minutnik?', 'a' => 'Tak. Naciśnij Wstrzymaj (albo spację) i Wznów, aby kontynuować. Możesz też dodać minutę, gdy minutnik działa.'],
        ],
    ],

    'sleep-calculator' => [
        'name' => 'Kalkulator snu',
        'title' => 'Kalkulator snu - najlepszy czas snu i pobudki',
        'description' => 'Znajdź najlepszy czas, aby zasnąć albo się obudzić, na podstawie 90-minutowych cykli snu, albo policz, ile godzin spałeś. Obudź się wypoczęty, nie zmęczony.',
        'h1' => 'Kalkulator snu',
        'tagline' => 'Znajdź najlepszą porę snu albo pobudki i policz godziny, które przespałeś.',
        'keywords' => ['kalkulator snu', 'licznik snu', 'kalkulator pory snu', 'kalkulator cyklu snu', 'kiedy iść spać', 'godziny snu'],
        'intro' => 'Kalkulator snu podpowiada, kiedy iść spać albo się obudzić, aby pobudka wypadła na końcu cyklu snu, gdy sen jest najlżejszy. Obudzenie się w połowie cyklu snu to powód, przez który budzik może Cię pozostawić zmęczonym nawet po całej nocy snu. Ten kalkulator snu działa z naturalnym rytmem cykli snu trwających około 90 minut: powiedz mu, kiedy musisz się obudzić, a podpowie Ci, kiedy iść spać, albo powiedz mu, kiedy idziesz spać, a podpowie najlepsze godziny budzika. Może też policzyć, ile godzin spałeś, i porównać je z zalecanymi 7-9 godzinami.',
        'steps' => [
            'Wybierz, co chcesz obliczyć: porę snu, porę pobudki, „Zaśnij teraz” albo przespane godziny.',
            'Wpisz swoją godzinę. Dostosuj, jak długo zwykle zasypiasz (domyślnie 15 minut).',
            'Wybierz jedną z zaproponowanych godzin. „Polecane” daje 7,5 godziny, a „Najlepszy odpoczynek” daje 9 godzin snu.',
            'Dotknij godziny, aby zobaczyć wykres cykli snu dla tej noc.',
        ],
        'features' => [
            'Pory snu dla wybranej godziny pobudki i pory pobudki dla wybranej pory snu',
            'Tryb „Zaśnij teraz” używający aktualnej godziny',
            'Licznik przespanych godzin z wytyczną 7-9 godzin',
            'Regulowany czas zasypiania i zegar 12 lub 24-godzinny',
            'Animowany wykres snu lekkiego, głębokiego i REM w ciągu nocy',
        ],
        'content' => [
            [
                'heading' => 'Co to jest cykl snu?',
                'body' => 'W ciągu nocy przechodzisz przez sen lekki, głęboki i REM (marzenia) w cyklach trwających około 90 minut, zwykle cztery do sześciu razy na noc. Wcześniejsze cykle zawierają najwięcej głębokiego snu, a późniejsze więcej snu REM. Przebudzenie na końcu cyklu, gdy sen jest najlżejszy, zwykle jest łatwiejsze niż wybudzenie z głębokiego snu.',
            ],
            [
                'heading' => 'Ile snu potrzebujesz?',
                'body' => 'Organizacje zajmujące się zdrowiem snu zalecają 7-9 godzin na noc dla dorosłych, 8-10 godzin dla nastolatków i 9-12 godzin dla dzieci szkolnych. Pięć pełnych cykli (7,5 godziny) albo sześć cykli (9 godzin) odpowiada tym wytycznym dla dorosłych. Każdy jest trochę inny, a długość cyklu różni się między ludźmi, więc traktuj zaproponowane godziny jako pomocną wskazówkę, a nie ścisłą regułę.',
            ],
        ],
        'faqs' => [
            ['q' => 'O której iść spać, aby wstać o 7:00?', 'a' => 'Aby wstać o 7:00, staraj się zasnąć do 23:30 dla pięciu cykli (7,5 godziny) albo do 22:00 dla sześciu cykli (9 godzin). Przy 15 minutach na zasypianie oznacza to pójście spać o 23:15 albo 21:45.'],
            ['q' => 'Jak długi jest jeden cykl snu?', 'a' => 'Cykl snu trwa przeciętnie około 90 minut, choć może wynosić od około 80 do 120 minut, zależnie od osoby i w ciągu nocy.'],
            ['q' => 'Czemu czuję się zmęczony po 8 godzinach snu?', 'a' => 'Jeśli budzik zadzwoni w czasie głębokiego snu, możesz czuć się zmęczony nawet po długiej nocy. Ustawienie budzika na koniec cyklu i regularny rozkład snu często pomaga.'],
            ['q' => 'Jak licznik snu wylicza przespane godziny?', 'a' => 'Wybierz „Przespane godziny”, wpisz, kiedy poszedłeś spać i kiedy się obudziłeś. Działa to przez północ, odjmuje czas potrzebny na zasypianie i porównuje wynik z 7-9 godzinami potrzebnymi dorosłym.'],
            ['q' => 'Czy ten kalkulator snu to porada medyczna?', 'a' => 'Nie. To ogólny przewodnik oparty na przeciętnych cyklach snu. Jeśli regularnie masz problemy ze snem, skontaktuj się z lekarzem.'],
        ],
        'table' => [
            'caption' => 'Pory snu dla popularnych godzin pobudki (15 minut na zasypianie)',
            'headers' => ['Pobudka o', '6 cykli (9 godz.)', '5 cykli (7,5 godz.)', '4 cykle (6 godz.)'],
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
        'name' => 'AVIF do JPG',
        'title' => 'Konwerter AVIF do JPG - darmowy, prywatny, wsadowy',
        'description' => 'Konwertuj AVIF do JPG online za darmo. Konwersja wsadowa do 30 obrazów, wybór jakości i pobieranie ZIP. Twoje obrazy nigdy nie opuszczają urządzenia.',
        'h1' => 'Konwerter AVIF do JPG',
        'tagline' => 'Zmień obrazy AVIF na pliki JPG, które otwierają się wszędzie.',
        'keywords' => ['avif do jpg', 'konwertuj avif do jpg', 'konwerter avif do jpg', 'avif do jpeg', 'otwórz plik avif'],
        'intro' => 'AVIF to nowoczesny format obrazów oparty na kodeku wideo AV1, który daje bardzo małe pliki, ale wiele aplikacji, edytorów i formularzy nadal go nie otwiera. Ten konwerter AVIF do JPG zmienia obrazy AVIF na JPG, najszerzej wspierany format obrazów. Wrzuć jeden obraz albo całą partię, wybierz jakość i pobierz wyniki pojedynczo albo jako ZIP.',
        'steps' => [
            'Upuść obrazy AVIF do pola albo kliknij, aby je wybrać (do 30 na raz).',
            'Dostosuj jakość JPG, jeśli chcesz; 85% zachowuje ostrość zdjęć przy małym rozmiarze pliku.',
            'Kliknij Pobierz przy obrazie albo Pobierz wszystko (ZIP) dla całej partii.',
        ],
        'features' => [
            'Konwertuje AVIF do JPG w Twojej przeglądarce',
            'Konwersja wsadowa do 30 obrazów z pobieraniem ZIP',
            'Regulowana jakość JPG',
            '100% prywatne: niczego nie wysyłamy',
        ],
        'content' => [
            ['heading' => 'Czemu konwertować AVIF do JPG?', 'body' => 'Pliki AVIF są często o 30-50% mniejsze niż JPG przy takiej samej jakości wizualnej, dlatego wiele stron serwuje teraz obrazy jako AVIF. Gdy zapisujesz taki obraz, starsze edytory zdjęć, dokumenty biurowe, drukarki i niektóre sieci społecznościowe mogą odmówić jego otwarcia. JPG działa praktycznie wszędzie, więc konwersja daje plik, który możesz użyć wszędzie.'],
            ['heading' => 'Co dzieje się z przezroczystością?', 'body' => 'JPG nie ma przezroczystości. Jeśli Twój obraz AVIF ma przezroczyste obszary, zostają wypełnione białym kolorem w JPG. Aby zachować przezroczystość, użyj zamiast tego konwertera AVIF do PNG.'],
        ],
        'faqs' => [
            ['q' => 'Jak przekonwertować AVIF na JPG?', 'a' => 'Upuść plik AVIF do pola powyżej. Jest od razu konwertowany na JPG, a wynik możesz pobrać jednym kliknięciem.'],
            ['q' => 'Czemu nie mogę otworzyć plików AVIF?', 'a' => 'AVIF jest nowszym formatem. Aktualne przeglądarki go otwierają, ale wiele starszych aplikacji i edytorów obrazów jeszcze go nie wspiera, dlatego konwersja na JPG jest najprostszym rozwiązaniem.'],
            ['q' => 'Czy JPG będzie większy niż AVIF?', 'a' => 'Zwykle tak. AVIF kompresuje obrazy wydajniej niż JPG, więc to samo zdjęcie zajmuje więcej miejsca jako JPG.'],
            ['q' => 'Czy moje obrazy są wysyłane?', 'a' => 'Nie. Twoja przeglądarka dekoduje AVIF i zapisuje JPG na Twoim urządzeniu, więc Twoje obrazy nigdy nie opuszczają komputera albo telefonu.'],
        ],
    ],

    'avif-to-png' => [
        'name' => 'AVIF do PNG',
        'title' => 'Konwerter AVIF do PNG - darmowy, zachowuje przezroczystość',
        'description' => 'Konwertuj AVIF do PNG online za darmo. Przezroczyste tła są zachowane, konwersja wsadowa do 30 obrazów i pobieranie ZIP. Niczego nie wysyłamy.',
        'h1' => 'Konwerter AVIF do PNG',
        'tagline' => 'Konwertuj obrazy AVIF na PNG z zachowaną przezroczystością.',
        'keywords' => ['avif do png', 'konwertuj avif do png', 'konwerter avif do png', 'konwerter avif', 'avif do png przezroczysty'],
        'intro' => 'Konwersja AVIF do PNG zmienia nowoczesny, silnie skompresowany obraz AVIF na bezstratny PNG, który otworzy praktycznie każda aplikacja. Przezroczyste tła zostają przezroczyste, co sprawia, że PNG jest dobrym wyborem do logo, ikon i grafik. Wrzuć jeden obraz albo partię i pobierz wyniki pojedynczo albo jako ZIP.',
        'steps' => [
            'Upuść obrazy AVIF do pola albo kliknij, aby je wybrać (do 30 na raz).',
            'Każdy obraz jest konwertowany do PNG od razu, w Twojej przeglądarce.',
            'Kliknij Pobierz przy obrazie albo Pobierz wszystko (ZIP) dla całej partii.',
        ],
        'features' => [
            'Konwertuje AVIF do bezstratnego PNG',
            'Zachowuje przezroczyste tła',
            'Konwersja wsadowa do 30 obrazów z pobieraniem ZIP',
            '100% prywatne: niczego nie wysyłamy',
        ],
        'content' => [
            ['heading' => 'Kiedy wybrać PNG zamiast JPG?', 'body' => 'Wybierz PNG do logo, ikon, zrzutów ekranu i wszystkiego z przezroczystymi obszarami albo ostrymi krawędziami, bo PNG jest bezstratny i wspiera przezroczystość. Do zwykłych zdjęć JPG daje dużo mniejsze pliki, więc AVIF do JPG jest zwykle lepszym wyborem.'],
            ['heading' => 'Czy konwersja AVIF do PNG zmniejsza jakość?', 'body' => 'Sama konwersja nie powoduje żadnej utraty, bo PNG zapisuje każdy piksel dokładnie. Jeśli oryginalny AVIF był zapisany ze stratną kompresją, ta wcześniejsza utrata zostaje, ale nic nowego nie jest dodawane.'],
        ],
        'faqs' => [
            ['q' => 'Jak przekonwertować AVIF na PNG?', 'a' => 'Upuść plik AVIF do pola powyżej. Jest konwertowany na PNG natychmiast, a wynik możesz pobrać jednym kliknięciem.'],
            ['q' => 'Czy przezroczystość jest zachowana?', 'a' => 'Tak. PNG wspiera przezroczystość, więc przezroczyste obszary w AVIF zostają przezroczyste w PNG.'],
            ['q' => 'Czemu PNG jest dużo większy?', 'a' => 'AVIF używa bardzo wydajnej kompresji, a PNG jest bezstratny, więc ten sam obraz może być kilka razy większy jako PNG.'],
            ['q' => 'Czy moje obrazy są wysyłane?', 'a' => 'Nie. Konwersja odbywa się w Twojej przeglądarce i Twoje obrazy nigdy nie opuszczają Twojego urządzenia.'],
        ],
    ],

    'avif-to-webp' => [
        'name' => 'AVIF do WebP',
        'title' => 'Konwerter AVIF do WebP - darmowy online, wsadowy',
        'description' => 'Konwertuj AVIF do WebP online za darmo. Zachowaj mały rozmiar i przezroczystość, konwersja wsadowa do 30 obrazów i ZIP. Niczego nie wysyłamy.',
        'h1' => 'Konwerter AVIF do WebP',
        'tagline' => 'Konwertuj AVIF na WebP i zachowaj mały rozmiar plików.',
        'keywords' => ['avif do webp', 'konwertuj avif do webp', 'konwerter avif do webp', 'avif webp', 'konwerter avif online'],
        'intro' => 'Konwersja AVIF do WebP daje mały, przyjazny dla sieci obraz, który przyjmuje więcej aplikacji i systemów zarządzania treścią niż AVIF. WebP zachowuje przezroczystość i dobrze się kompresuje, więc pliki zostają dużo mniejsze niż PNG albo JPG. Wrzuć jeden obraz albo partię, wybierz jakość i pobierz wyniki.',
        'steps' => [
            'Upuść obrazy AVIF do pola albo kliknij, aby je wybrać (do 30 na raz).',
            'Dostosuj jakość WebP, jeśli chcesz; 85% to dobry balans między rozmiarem i ostrością.',
            'Kliknij Pobierz przy obrazie albo Pobierz wszystko (ZIP) dla całej partii.',
        ],
        'features' => [
            'Konwertuje AVIF do WebP w Twojej przeglądarce',
            'Zachowuje przezroczyste tła',
            'Regulowana jakość i pobieranie wsadowe ZIP',
            '100% prywatne: niczego nie wysyłamy',
        ],
        'content' => [
            ['heading' => 'AVIF czy WebP: który wybrać?', 'body' => 'Obydwa to nowoczesne formaty z przezroczystością. AVIF zwykle daje mniejsze pliki, ale WebP istnieje dłużej i przyjmuje go więcej aplikacji, wtyczek i formularzy. Konwersja na WebP jest dobrym rozwiązaniem, gdy strona albo narzędzie nie przyjmuje AVIF, a Ty wciąż chcesz małych obrazów.'],
            ['heading' => 'Czy WebP wygląda tak samo?', 'body' => 'Przy jakości 85% lub wyższej różnicę bardzo trudno zauważyć. Każdy stratny zapis może utracić odrobinę szczegółów, więc do archiwizacji albo dalszej edycji AVIF do PNG zachowuje każdy piksel.'],
        ],
        'faqs' => [
            ['q' => 'Jak przekonwertować AVIF na WebP?', 'a' => 'Upuść plik AVIF do pola powyżej, wybierz jakość i pobierz plik WebP jednym kliknięciem.'],
            ['q' => 'Czy przezroczystość jest zachowana?', 'a' => 'Tak. WebP wspiera przezroczystość, więc przezroczyste obszary zostają przezroczyste.'],
            ['q' => 'Które przeglądarki to obsługują?', 'a' => 'Aktualne wersje Chrome, Edge, Firefox i Safari mogą dekodować AVIF i zapisywać WebP, więc konwerter działa w nich wszystkich.'],
            ['q' => 'Czy moje obrazy są wysyłane?', 'a' => 'Nie. Wszystko odbywa się w Twojej przeglądarce i Twoje obrazy nigdy nie opuszczają Twojego urządzenia.'],
        ],
    ],

    'readability-checker' => [
        'name' => 'Sprawdzanie czytelności tekstu',
        'title' => 'Czytelność tekstu - wskaźnik Flescha i poziom klasy',
        'description' => 'Darmowe sprawdzanie czytelności: wskaźnik Flescha, poziom klasy, Gunning Fog i SMOG, oraz lista zbyt długich zdań do poprawy. Tekst pozostaje prywatny.',
        'h1' => 'Sprawdzanie czytelności tekstu',
        'tagline' => 'Sprawdź, jak łatwo czyta się Twój tekst i co poprawić.',
        'keywords' => ['sprawdzanie czytelności', 'czytelność tekstu ai', 'wskaźnik czytelności', 'kalkulator flesch reading ease', 'poziom flesch kincaid', 'test czytelności'],
        'intro' => 'Sprawdzanie czytelności mierzy, jak łatwo czyta się tekst, za pomocą wzorów opartych na długości zdań i słów. Wklej artykuł, wypracowanie, e-mail albo szkic napisany przez AI, aby otrzymać wskaźnik Flesch Reading Ease, poziom klasy szkolnej na podstawie pięciu wzorów oraz listę długich zdań do skrócenia. Twój tekst jest analizowany w Twojej przeglądarce i nigdy nie jest wysyłany.',
        'steps' => [
            'Wklej albo wpisz swój tekst do pola.',
            'Przeczytaj wskaźnik Flesch Reading Ease i poziom klasy z każdego wzoru.',
            'Skróć długie zdania wskazane pod wynikami, a potem sprawdź ponownie.',
        ],
        'features' => [
            'Flesch Reading Ease i poziom klasy Flesch-Kincaid',
            'Gunning Fog, SMOG, Coleman-Liau i Automated Readability Index',
            'Wyróżnia zdania dłuższe niż 25 słów',
            'Natychmiastowe wyniki; niczego nie wysyłamy',
        ],
        'content' => [
            ['heading' => 'Jaki jest dobry wskaźnik czytelności?', 'body' => 'Dla większości stron, blogów i e-maili celuj w wskaźnik Flesch Reading Ease co najmniej 60, czyli prosty język, który większość dorosłych czyta z łatwością, i poziom klasy około 8 lub niższy. Teksty techniczne i akademickie często mają 30-50, co jest w porządku dla czytelników eksperckich, ale trudne dla innych.'],
            ['heading' => 'Jak pisać tak, żeby łatwiej się czytało?', 'body' => 'Rozdziel długie zdania na dwa, wybieraj krótkie, codzienne słowa zamiast długich, używaj czasowników w stronie aktywnej i dziel duże akapity na mniejsze. Te zmiany podnoszą wskaźnik Flescha wprost, bo jest on wyliczany ze słów na zdanie i sylab na słowo.'],
        ],
        'faqs' => [
            ['q' => 'Co to jest wskaźnik Flesch Reading Ease?', 'a' => 'To wynik od 0 do 100 oparty na średniej długości zdań i sylabach na słowo. Wyższe wyniki są łatwiejsze: 60-70 to prosty język, a 90+ to bardzo łatwy tekst.'],
            ['q' => 'Co znaczy poziom klasy?', 'a' => 'To amerykańska klasa szkolna, jaką czytelnik potrzebuje, aby zrozumieć tekst. Klasa 8 oznacza, że typowy 13-14-latek może go przeczytać.'],
            ['q' => 'Czy mogę sprawdzić tekst napisany przez AI?', 'a' => 'Tak. Szkice AI często używają długich zdań i długich słów; narzędzie pokazuje, które zdania skrócić, aby tekst brzmiał bardziej naturalnie.'],
            ['q' => 'Czy działa w innych językach?', 'a' => 'Wzory zostały zaprojektowane dla angielskiego, więc wyniki dla innych języków są tylko przybliżonym wskazaniem.'],
        ],
        'table' => [
            'caption' => 'Wyniki wskaźnika Flesch Reading Ease',
            'headers' => ['Wynik', 'Poziom', 'Typowy czytelnik'],
            'rows' => [
                ['90-100', 'Bardzo łatwy', '11 lat'],
                ['60-70', 'Prosty język', '13-15 lat'],
                ['30-50', 'Trudny', 'Studia'],
                ['0-30', 'Bardzo trudny', 'Absolwent studiów'],
            ],
        ],
    ],

    'ai-content-detector' => [
        'name' => 'Wykrywacz treści AI',
        'title' => 'Wykrywacz treści AI - darmowy sprawdzacz tekstu',
        'description' => 'Darmowy wykrywacz treści AI: sprawdź, czy tekst wygląda na napisany przez AI, zobacz wynik podobieństwa, zdradzające zwroty i cztery sygnały. Prywatne.',
        'h1' => 'Wykrywacz treści AI',
        'tagline' => 'Sprawdź, jak bardzo tekst brzmi jak AI, i czemu.',
        'keywords' => ['wykrywacz treści ai', 'detektor ai', 'sprawdzacz tekstu ai', 'wykrywacz chatgpt', 'wykryj tekst ai', 'darmowy sprawdzacz ai'],
        'intro' => 'Wykrywacz treści AI szacuje, czy tekst został napisany przez chatbota AI, taki jak ChatGPT. Ten analizuje cztery sygnały pisarskie, które różnią się między typowym tekstem AI i ludzkim: jak równomierna jest długość zdań, zwroty typowe dla AI, formy ściągnięte i różnorodność słownictwa. Podaje wynik podobieństwa do AI i pokazuje dokładnie, co go podniosło. Działa z tekstem angielskim w Twojej przeglądarce, niczego nie wysyłając.',
        'steps' => [
            'Wklej co najmniej 80 słów tekstu angielskiego do pola.',
            'Kliknij Sprawdź tekst, aby otrzymać wynik podobieństwa do AI i cztery sygnały.',
            'Przejrzyj znalezione zwroty typowe dla AI; ich przeredagowanie sprawia, że tekst brzmi bardziej po ludzku.',
        ],
        'features' => [
            'Wynik podobieństwa do AI od 0 do 100%',
            'Pokazuje znalezione zwroty typowe dla AI',
            'Wyjaśnia każdy sygnał prostymi słowami',
            'Darmowe, bez limitów i prywatne: niczego nie wysyłamy',
        ],
        'content' => [
            ['heading' => 'Jak działa wykrywanie AI?', 'body' => 'Modele AI mają tendencję do pisania bardzo równomiernych zdań, powtarzania tych samych wypolerowanych zwrotów („co więcej”, „warto zauważyć”, „zgłębić”) i unikania form ściągniętych. Ludzie zwykle mieszają krótkie i długie zdania i piszą bardziej swobodnie. Wykrywacz mierzy te wzorce i łączy je w jeden wynik.'],
            ['heading' => 'Jak dokładne są wykrywacze AI?', 'body' => 'Żaden wykrywacz AI nie jest w pełni wiarygodny. Formalny tekst napisany przez człowieka może uzyskać wysoki wynik, a tekst AI, który został zredagowany albo napisany tak, żeby brzmieć swobodnie, może uzyskać niski. Traktuj wynik jako wskazówkę, by przyjrzeć się bliżej, nigdy jako dowód, i nigdy nie używaj go samego do oskarżenia ucznia albo autora o oszustwo.'],
        ],
        'faqs' => [
            ['q' => 'Czy wykrywa ChatGPT?', 'a' => 'Narzędzie oznacza wzorce pisarskie, które ChatGPT i podobne modele często tworzą. Zredagowany albo starannie napisany tekst AI może nie zostać wykryty.'],
            ['q' => 'Ile tekstu potrzebuję?', 'a' => 'Co najmniej 80 słów. Dłuższe teksty, 300 słów lub więcej, dają bardziej znaczący wynik.'],
            ['q' => 'Czy tekst ludzki może uzyskać wynik jak AI?', 'a' => 'Tak. Bardzo formalny, równomierny tekst ze zwrotami jak „ponadto” może uzyskać wysoki wynik, nawet gdy napisał go człowiek. Dlatego wynik jest tylko wskazówką.'],
            ['q' => 'Czy mój tekst jest zapisywany?', 'a' => 'Nie. Analiza odbywa się w Twojej przeglądarce i Twój tekst nigdzie nie jest wysyłany.'],
        ],
    ],

    'remove-background' => [
        'name' => 'Usuwanie tła',
        'title' => 'Usuń tło ze zdjęcia - darmowe, bez wysyłania plików',
        'description' => 'Usuń tło z każdego zdjęcia za darmo za pomocą AI. Pobierz przezroczysty PNG albo dodaj kolor w kilka sekund. Działa w przeglądarce, zdjęcia nie są wysyłane.',
        'h1' => 'Usuń tło ze zdjęcia',
        'tagline' => 'Wycinaj ludzi, produkty i zwierzęta jednym kliknięciem.',
        'keywords' => ['usuwanie tła', 'usuwacz tła', 'usuń tło', 'przezroczyste tło', 'usuń tło ze zdjęcia', 'generator png'],
        'intro' => 'Usuwacz tła wycina główny obiekt ze zdjęcia i sprawia, że wszystko za nim staje się przezroczyste. Ten korzysta z modelu AI, który działa w Twojej przeglądarce: wrzuć zdjęcie osoby, produktu, zwierzęcia albo logo i pobierz przezroczysty PNG, albo umieść je na białym lub innym kolorowym tle. Twoje zdjęcie nigdy nie jest wysyłane; tylko model AI jest pobierany jednorazowo.',
        'steps' => [
            'Upuść obraz JPG, PNG, WebP albo AVIF do pola.',
            'Zaczekaj kilka sekund, aż AI usunie tło (pierwsze uruchomienie pobiera też model).',
            'Wybierz przezroczyste, białe albo kolorowe tło i kliknij Pobierz PNG.',
        ],
        'features' => [
            'Usuwanie tła przez AI w Twojej przeglądarce',
            'Przezroczysty PNG, białe albo dowolne kolorowe tło',
            'Szybki tryb dla każdego urządzenia, tryb wysokiej jakości z WebGPU',
            'Darmowe, bez rejestracji, bez znaku wodnego, niczego nie wysyłamy',
        ],
        'content' => [
            ['heading' => 'Szybki czy wysokiej jakości: który wybrać?', 'body' => 'Tryb szybki korzysta z małego modelu 4,4 MB, który działa na każdym telefonie czy komputerze i dobrze radzi sobie z wyraźnymi obiektami, takimi jak produkty, ludzie i logo. Tryb wysokiej jakości pobiera jednorazowo większy, 109 MB model i daje czystsze krawędzie wokół włosów, futra i drobnych szczegółów. Wymaga przeglądarki z WebGPU, takiej jak nowy Chrome albo Edge.'],
            ['heading' => 'Jak uzyskać najlepsze wycięcie?', 'body' => 'Użyj zdjęcia, na którym obiekt jest w ostrości i wyróżnia się od tła kolorem lub jasnością. Zabiegane tła, rozmycie ruchu i obiekty zlewające się z tłem są trudniejsze dla każdego modelu AI. Jeśli krawędź wygląda nierówno w trybie szybkim, spróbuj trybu wysokiej jakości.'],
        ],
        'faqs' => [
            ['q' => 'Czy usuwacz tła jest naprawdę darmowy?', 'a' => 'Tak. Nie ma rejestracji, dziennego limitu ani znaku wodnego, a pobierasz wynik w pełnym rozmiarze.'],
            ['q' => 'Czy moje zdjęcia są wysyłane?', 'a' => 'Nie. Model AI działa w Twojej przeglądarce, więc Twoje zdjęcia zostają na Twoim urządzeniu. Tylko plik modelu jest pobierany i zapisywany na następny raz.'],
            ['q' => 'Jakich formatów obrazów mogę używać?', 'a' => 'JPG, PNG, WebP i AVIF, do 50 MB. Wynikiem jest PNG z przezroczystym tłem albo z wybranym przez Ciebie kolorem.'],
            ['q' => 'Czemu pierwsze uruchomienie jest wolniejsze?', 'a' => 'Po pierwszym razie Twoja przeglądarka pobiera model AI (4,4 MB dla trybu szybkiego, 109 MB dla wysokiej jakości). Potem jest zapisany w przeglądarce i startuje dużo szybciej.'],
        ],
    ],

    'broken-link-checker' => [
        'name' => 'Sprawdzanie uszkodzonych linków',
        'title' => 'Sprawdzanie uszkodzonych linków - darmowy wykrywacz błędów',
        'description' => 'Darmowe sprawdzanie linków: znajdź błędy 404, martwe linki, uszkodzone obrazy i przekierowania na stronie w kilka sekund, wyeksportuj listę do CSV.',
        'h1' => 'Sprawdzanie uszkodzonych linków',
        'tagline' => 'Znajdź martwe linki, błędy 404 i przekierowania na każdej stronie.',
        'keywords' => ['sprawdzanie uszkodzonych linków', 'wykrywacz martwych linków', 'sprawdzenie linków', 'sprawdzanie błędów 404', 'sprawdzanie linków', 'znajdź uszkodzone linki'],
        'intro' => 'Sprawdzanie uszkodzonych linków znajduje na stronie linki, które już nie działają, takie jak błędy 404 „strona nie znaleziona”, usunięte obrazy i domeny, które wygasły. Wpisz adres strony, a narzędzie przetestuje każdy link i obraz na niej (do 300), pokaże, które są uszkodzone, które przekierowują, a które działają, i pozwoli pobrać wyniki jako plik CSV.',
        'steps' => [
            'Wpisz adres strony, którą chcesz sprawdzić, na przykład przyklad.pl/blog.',
            'Kliknij Sprawdź linki; wyniki wypełniają się, gdy każda partia linków jest testowana.',
            'Napraw albo usuń uszkodzone linki pokazane w Problemach i zaktualizuj te, które przekierowują.',
        ],
        'features' => [
            'Sprawdza każdy link i obraz na stronie (do 300)',
            'Znajduje błędy 404, błędy serwera, martwe domeny i przekierowania',
            'Pokazuje tekst linku i czy jest wewnętrzny albo zewnętrzny',
            'Darmowy eksport do CSV, bez rejestracji',
        ],
        'content' => [
            ['heading' => 'Czemu uszkodzone linki mają znaczenie?', 'body' => 'Uszkodzone linki wysyłają odwiedzających na strony błędów, co jest frustrujące i sprawia, że strona wygląda zaniedbana. Wyszukiwarki też śledzą linki, aby odkrywać strony, więc martwe linki trwonią ich czas indeksowania i mogą uniemożliwić znalezienie ważnych stron. Naprawienie ich to jedna z najszybszych korzyści dla SEO i doświadczenia użytkownika.'],
            ['heading' => 'Co znaczą wyniki?', 'body' => 'OK oznacza, że link działa. Przekierowanie oznacza, że działa, ale przechodzi przez jedno lub więcej przekierowań; zaktualizowanie go na końcowy adres jest szybsze dla odwiedzających. Uszkodzony oznacza, że strona odpowiedziała błędem, takim jak 404 lub 500, albo domena już nie istnieje. Zablokowany oznacza, że strona odmówiła automatycznego sprawdzenia (status 401, 403 lub 429), więc otwórz link samodzielnie, aby potwierdzić.'],
        ],
        'faqs' => [
            ['q' => 'Jak znaleźć uszkodzone linki na mojej stronie?', 'a' => 'Wpisz adres strony powyżej i kliknij Sprawdź linki. Powtórz to dla najważniejszych stron, takich jak strona główna, menu i popularne artykuły.'],
            ['q' => 'Czy sprawdza całą witrynę?', 'a' => 'Sprawdza każdy link i obraz na podanej stronie, do 300. Aby sprawdzić inne strony, wpisz ich adresy po kolei.'],
            ['q' => 'Czemu niektóre linki są oznaczone jako Zablokowane?', 'a' => 'Niektóre strony odmawiają automatycznych zapytań albo wymagają logowania, odpowiadając statusem 401, 403 lub 429. Link może wciąż działać w normalnej przeglądarce, więc otwórz go, aby sprawdzić.'],
            ['q' => 'Czy strona albo moje wyniki są zapisywane?', 'a' => 'Nie. Nasz serwer pobiera stronę i linki tylko, aby je sprawdzić, i nie zapisuje adresu ani wyników.'],
        ],
        'table' => [
            'caption' => 'Częste kody statusu HTTP',
            'headers' => ['Kod', 'Znaczenie', 'Co zrobić'],
            'rows' => [
                ['200', 'OK', 'Nic'],
                ['301 / 308', 'Przeniesiono trwale', 'Zaktualizuj link na nowy adres'],
                ['404', 'Strona nie znaleziona', 'Napraw albo usuń link'],
                ['410', 'Usunięte na trwałe', 'Usuń link'],
                ['500 / 503', 'Błąd serwera', 'Sprawdź ponownie później; poinformuj właściciela strony'],
            ],
        ],
    ],

    'domain-authority-checker' => [
        'name' => 'Masowy sprawdzacz autorytetu domeny',
        'title' => 'Sprawdzacz autorytetu domeny - darmowy, bez rejestracji',
        'description' => 'Darmowy masowy sprawdzacz autorytetu domeny: wynik autorytetu, globalna ranga i domeny odsyłające dla do 100 witryn na raz, bez rejestracji, natychmiast.',
        'h1' => 'Masowy sprawdzacz autorytetu domeny',
        'tagline' => 'Porównaj autorytet do 100 witryn w kilka sekund.',
        'keywords' => ['sprawdzacz autorytetu domeny', 'masowy sprawdzacz autorytetu domeny', 'masowy sprawdzacz da', 'sprawdzacz autorytetu witryny', 'sprawdzacz domain rating', 'sprawdź autorytet domeny'],
        'intro' => 'Sprawdzacz autorytetu domeny szacuje, jak silna jest witryna w wyszukiwarkach, na podstawie liczby innych witryn, które do niej linkują, i tego, jak ważne są te witryny. Wklej do 100 domen, aby zobaczyć wynik OpenPageRank każdej z nich od 0 do 10, jej globalną rangę i domeny odsyłające, sortuj je i pobierz jako CSV. Przydatne do porównywania konkurentów, sprawdzania partnerów linkowych i oceny witryn do gościnnych wpisów.',
        'steps' => [
            'Wklej do 100 domen albo adresów stron, jedną w wierszu.',
            'Kliknij Sprawdź autorytet.',
            'Sortuj wyniki według wyniku i pobierz je jako CSV, jeśli potrzebujesz ich później.',
        ],
        'features' => [
            'Do 100 domen w jednym sprawdzeniu',
            'Wynik autorytetu od 0 do 10, globalna ranga i domeny odsyłające',
            'Przyjmuje pełne adresy URL i automatycznie usuwa www',
            'Darmowy eksport do CSV, bez rejestracji',
        ],
        'content' => [
            ['heading' => 'Czy to to samo co Moz Domain Authority?', 'body' => 'Nie. Domain Authority (DA) to wynik od 0 do 100 należący do Moz, a Domain Rating (DR) należy do Ahrefs. To narzędzie pokazuje OpenPageRank, wynik od 0 do 10 wyliczany z publicznego grafu linków Common Crawl metodą PageRank. Wszystkie te metryki mierzą tę samą ideę, czyli siłę linków witryny, ale są wyliczane inaczej, więc liczb nie można przeliczyć jednej na drugą.'],
            ['heading' => 'Jaki wynik jest dobry?', 'body' => 'Skala jest logarytmiczna: przejście z 2 na 3 wymaga dużo mniej linków niż przejście z 8 na 9. Nowe witryny zwykle zaczynają blisko 0, małe ugruntowane witryny często mają 2-4, znane marki 5-7, a tylko największe witryny w internecie osiągają 9 lub 10. Porównuj witrynę z innymi w tej samej niszy, a nie z największymi witrynami.'],
        ],
        'faqs' => [
            ['q' => 'Jak sprawdzić autorytet domeny witryny?', 'a' => 'Wklej domenę do pola i kliknij Sprawdź autorytet. Możesz sprawdzić do 100 domen na raz.'],
            ['q' => 'Skąd pochodzą wyniki?', 'a' => 'Z OpenPageRank, który wylicza autorytet z grafu Common Crawl, publicznego indeksu miliardów stron internetowych. Wyniki są aktualizowane co miesiąc.'],
            ['q' => 'Jak mogę zwiększyć swój wynik?', 'a' => 'Zdobywaj linki z poważanych witryn w swojej branży: wartościowe treści, wpisy w dobrych katalogach, gościnne artykuły i wzmianki w mediach. Linki z wielu różnych witryn liczą się bardziej niż wiele linków z jednej.'],
            ['q' => 'Czemu witryna pokazuje Nie znaleziono?', 'a' => 'Bardzo nowe albo bardzo małe witryny mogą nie mieć jeszcze wystarczającej liczby linków w grafie, aby otrzymać wynik.'],
        ],
        'table' => [
            'caption' => 'Porównanie metryk autorytetu',
            'headers' => ['Metryka', 'Twórca', 'Skala'],
            'rows' => [
                ['OpenPageRank', 'OpenPageRank (dane Common Crawl)', '0-10'],
                ['Domain Authority (DA)', 'Moz', '0-100'],
                ['Domain Rating (DR)', 'Ahrefs', '0-100'],
                ['Authority Score', 'Semrush', '0-100'],
            ],
        ],
    ],

    'domain-age-checker' => [
        'name' => 'Sprawdzanie wieku domeny',
        'title' => 'Sprawdzanie wieku domeny: kiedy została zarejestrowana?',
        'description' => 'Darmowe sprawdzanie wieku domeny: wiek, data wygaśnięcia, rejestrator i serwery nazw do 20 domen, na podstawie danych RDAP, następcy WHOIS.',
        'h1' => 'Sprawdzanie wieku domeny',
        'tagline' => 'Sprawdź dokładny wiek, datę wygaśnięcia i rejestratora do 20 domen.',
        'keywords' => [
            'sprawdzanie wieku domeny',
            'wiek domeny',
            'kiedy zarejestrowano domenę',
            'data rejestracji domeny',
            'wyszukiwarka domen',
            'zapytanie rdap',
        ],
        'intro' => 'Narzędzie do sprawdzania wieku domeny odpytuje oficjalny rejestr nazwy domeny, aby pokazać dokładnie, ile ma lat. Wpisz do 20 domen, aby zobaczyć datę utworzenia każdej z nich, dokładny wiek w latach, miesiącach i dniach, datę wygaśnięcia, datę ostatniej aktualizacji, rejestratora i serwery nazw, pobrane na żywo z RDAP, darmowego następcy WHOIS niewymagającego klucza. Przydaje się to przy sprawdzaniu strony przed jej kupnem lub umieszczeniem linku, sprawdzaniu, jak długo firma działa online, oraz pilnowaniu terminów odnowienia własnych domen.',
        'steps' => [
            'Wpisz do 20 domen lub adresów stron, po jednym w wierszu.',
            'Kliknij Sprawdź wiek domeny.',
            'Sprawdź wiek, daty, rejestratora i serwery nazw każdej domeny albo pobierz wyniki jako CSV.',
        ],
        'features' => [
            'Do 20 domen w jednym sprawdzeniu',
            'Dokładny wiek w latach, miesiącach i dniach, a także daty utworzenia, wygaśnięcia i ostatniej aktualizacji',
            'Rejestrator, kody statusu i serwery nazw każdej domeny',
            'Dane na żywo z RDAP, bez rejestracji, darmowy eksport CSV',
        ],
        'content' => [
            [
                'heading' => 'Czym jest RDAP i czym różni się od WHOIS?',
                'body' => 'RDAP (Registration Data Access Protocol) to nowoczesny, ustandaryzowany następca WHOIS. Podczas gdy WHOIS zwraca zwykły tekst w formacie, który różni się w zależności od rejestru, RDAP zwraca ustrukturyzowany JSON z takimi samymi nazwami pól wszędzie, jest darmowy i nie wymaga klucza, a także obsługuje umiędzynarodowione nazwy domen i precyzyjną kontrolę dostępu. ICANN zobowiązała wszystkich akredytowanych rejestratorów i rejestry gTLD do udostępniania RDAP, a rejestry krajowe, takie jak niemiecki DENIC czy polski NASK, również je dodały, więc WHOIS jest stopniowo wypierane przez RDAP.',
            ],
            [
                'heading' => 'Dlaczego niektóre domeny pokazują „niewspierane” lub „nie znaleziono rekordu”?',
                'body' => 'Niewielka liczba krajowych rozszerzeń domen nie wdrożyła jeszcze usługi RDAP, więc nie da się skontaktować z żadnym rejestrem dla nich; takie domeny pokazują „niewspierane”. Domena może też nie pokazać rekordu, jeśli nie jest obecnie zarejestrowana, została zarejestrowana bardzo niedawno i nie pojawiła się jeszcze w publicznych danych rejestru, albo gdy rejestr jest tymczasowo niedostępny. Żadna z tych sytuacji nie oznacza błędu narzędzia: pokazywane daty zawsze pochodzą bezpośrednio z odpowiedzi rejestru na żywo, nigdy nie są szacowane.',
            ],
        ],
        'faqs' => [
            [
                'q' => 'Jak mogę sprawdzić, ile lat ma domena?',
                'a' => 'Wpisz domenę powyżej i kliknij Sprawdź wiek domeny. Dokładna data rejestracji oraz wiek w latach, miesiącach i dniach pochodzą bezpośrednio z rekordu RDAP domeny.',
            ],
            [
                'q' => 'Czy to te same informacje co w wyszukiwarce WHOIS?',
                'a' => 'Tak, to te same dane rejestracyjne, ale odczytane z RDAP, ustrukturyzowanego protokołu bez klucza, który zastępuje WHOIS. Data, rejestrator i serwery nazw pochodzą z tego samego rekordu w obu przypadkach.',
            ],
            [
                'q' => 'Dlaczego data wygaśnięcia ma znaczenie?',
                'a' => 'Domena, która nie zostanie odnowiona przed datą wygaśnięcia, może wejść w okres karencji, a potem zostać zwolniona do rejestracji przez kogokolwiek. Sprawdzenie daty wygaśnięcia strony to szybki sposób na ocenę, jak aktywnie jest ona utrzymywana.',
            ],
            [
                'q' => 'Czy mogę sprawdzić dowolne rozszerzenie domeny?',
                'a' => 'Większość popularnych rozszerzeń (w tym .com, .net, .org, .io, .co.uk, .de i .pl) ma rekordy RDAP. Niewielka liczba mniejszych rozszerzeń krajowych nie wdrożyła jeszcze RDAP; takie domeny są pokazywane jako niewspierane, zamiast zgadywać dane.',
            ],
            [
                'q' => 'Kiedy domena została zarejestrowana?',
                'a' => 'Rekord RDAP domeny przechowuje datę utworzenia: dzień, w którym została zarejestrowana po raz pierwszy, nawet jeśli od tego czasu zmieniła właściciela. Wpisz domenę powyżej, a narzędzie odczyta tę dokładną datę bezpośrednio z rejestru, wraz z wiekiem w latach, miesiącach i dniach.',
            ],
        ],
        'table' => [
            'caption' => 'Pokazywane typy zdarzeń RDAP',
            'headers' => ['Pole', 'Zdarzenie RDAP', 'Znaczenie'],
            'rows' => [
                ['Utworzono', 'registration', 'Kiedy domena została zarejestrowana po raz pierwszy'],
                ['Wygasa', 'expiration', 'Kiedy kończy się obecny okres rejestracji'],
                ['Ostatnia aktualizacja', 'last changed', 'Kiedy sam rekord rejestru został ostatnio zmieniony'],
            ],
        ],
    ],
    'rotate-pdf' => [
        'name' => 'Obróć PDF',
        'title' => 'Obróć PDF - Napraw Przekrzywione Strony Bezpłatnie',
        'description' => 'Obróć strony PDF o 90, 180 lub 270 stopni bezpłatnie online. Obróć cały dokument lub tylko wybrane strony. Bez wysyłania plików, znaku wodnego i rejestracji.',
        'h1' => 'Obróć PDF',
        'tagline' => 'Ustaw przekrzywione lub odwrócone strony we właściwej orientacji, prosto w przeglądarce.',
        'keywords' => ['obróć pdf', 'obracanie pdf', 'obróć strony pdf', 'obróć pdf online', 'naprawić przekrzywiony pdf'],
        'intro' => 'Zeskanowana strona lub zdjęcie zrobione w niewłaściwej orientacji często trafia do PDF-a przekrzywione lub odwrócone do góry nogami. To narzędzie do obracania PDF obraca strony o 90, 180 lub 270 stopni, dzięki czemu czyta się je we właściwej orientacji. Obróć cały dokument naraz albo wybierz tylko te strony, które tego wymagają, a potem pobierz poprawiony plik. Wszystko dzieje się na Twoim urządzeniu - Twój PDF nigdy nie jest wysyłany na serwer.',
        'steps' => [
            'Wybierz PDF, który chcesz poprawić.',
            'Kliknij stronę, aby ją wybrać, albo nie wybieraj żadnej, aby obrócić cały dokument.',
            'Kliknij 90°, 90° lub 180°, aby obrócić wybrane strony (lub wszystkie).',
            'Kliknij Obróć PDF i pobierz poprawiony plik.',
        ],
        'features' => [
            'Obróć o 90, 180 lub 270 stopni',
            'Obróć cały dokument lub tylko wybrane strony',
            'Miniatury pokazują wynik przed pobraniem',
            'Bez znaku wodnego i bez utraty jakości',
            'Prywatność - Twój PDF nigdy nie opuszcza Twojego urządzenia',
        ],
        'content' => [
            ['heading' => 'Czemu strony PDF są przekrzywione?', 'body' => 'Skanery i aparaty w telefonach czasami zapisują jedną stronę w orientacji poziomej wewnątrz dokumentu, który w pozostałej części jest pionowy, przez co ta strona wydaje się przekrzywiona podczas czytania PDF-a. Obrócenie tylko tej strony, a nie całego pliku, naprawia problem bez wpływu na resztę dokumentu.'],
            ['heading' => 'Czy obracanie zmienia zawartość strony?', 'body' => 'Nie. Obracanie zmienia tylko znacznik orientacji strony, który każdy czytnik i drukarka PDF wykorzystuje do jej prawidłowego wyświetlenia. Tekst, obrazy i jakość samej strony nie są zmieniane.'],
        ],
        'faqs' => [
            ['q' => 'Czy mogę obrócić tylko jedną stronę, a nie cały PDF?', 'a' => 'Tak. Kliknij miniaturę strony (lub stron), które chcesz poprawić, przed kliknięciem przycisku obracania; obrócą się tylko wybrane strony. Nie wybieraj żadnej, aby obrócić wszystkie.'],
            ['q' => 'Jakie kąty obrotu są dostępne?', 'a' => 'Obróć o 90 stopni w lewo lub w prawo, albo obróć stronę o 180 stopni, jeśli została zeskanowana do góry nogami. Możesz łączyć kliknięcia, aby uzyskać każdą z czterech orientacji.'],
            ['q' => 'Czy mój PDF jest wysyłany na serwer?', 'a' => 'Nie. PDF jest otwierany i obracany całkowicie w Twojej przeglądarce za pomocą JavaScript i nigdy nie jest nigdzie wysyłany.'],
            ['q' => 'Czy to dodaje znak wodny albo zmniejsza jakość?', 'a' => 'Nie. Obracanie zmienia tylko orientację każdej strony. Nie dodaje się żadnego znaku wodnego, logo ani dodatkowych stron, a jakość obrazu i tekstu nie jest tracona.'],
        ],
    ],    'delete-pdf-pages' => [
        'name' => 'Usuń strony PDF',
        'title' => 'Usuń Strony PDF - Usuwanie Stron Bezpłatnie',
        'description' => 'Usuń strony z PDF bezpłatnie online. Kliknij miniatury lub wpisz zakresy, np. 2, 4-6. Bez wysyłania plików, znaku wodnego i rejestracji.',
        'h1' => 'Usuń strony PDF',
        'tagline' => 'Usuń strony, których nie potrzebujesz, prosto w przeglądarce.',
        'keywords' => ['usuń strony pdf', 'usuwanie stron pdf', 'usuń stronę z pdf', 'usuwanie stron z pdf online', 'usuń stronę pdf'],
        'intro' => 'Pustą okładkę, zduplikowany skan lub niepotrzebną stronę można usunąć z PDF-a bez tworzenia całego pliku od nowa. To narzędzie usuwa strony z PDF-a po kliknięciu miniatury lub wpisaniu zakresów, np. 2, 4-6, a potem zapisuje nowy plik tylko z tymi stronami, które chcesz zachować. Wszystko dzieje się na Twoim urządzeniu, więc PDF nigdy nie jest wysyłany.',
        'steps' => [
            'Wybierz PDF, który chcesz edytować.',
            'Kliknij miniaturę każdej strony do usunięcia albo przełącz na zakresy stron i wpisz numery, np. 2, 4-6.',
            'Sprawdź strony oznaczone do usunięcia w siatce.',
            'Kliknij Usuń strony i pobierz nowy PDF.',
        ],
        'features' => [
            'Wybieraj strony przez miniatury lub wpisując zakresy',
            'Miniatury pokazują dokładnie to, co usuwasz',
            'Zawsze zostaje przynajmniej jedna strona - nie da się usunąć wszystkiego przez pomyłkę',
            'Bez znaku wodnego i bez utraty jakości na pozostałych stronach',
            'Prywatność - Twój PDF nigdy nie opuszcza Twojego urządzenia',
        ],
        'content' => [
            ['heading' => 'Kiedy usuwać strony, a nie dzielić', 'body' => 'Użyj tego narzędzia, gdy większość PDF-a jest w porządku i tylko kilka stron musi zniknąć, na przykład pusta strona, duplikat albo stara okładka. Jeśli chcesz zamiast tego wydzielić konkretne strony do własnego pliku, służy do tego tryb "Wyodrębnij strony" w Dziel PDF.'],
            ['heading' => 'Czy usunięta strona może zostać przywrócona?', 'body' => 'Nie z nowego pliku - po pobraniu usunięte strony znikają z tej kopii. Zachowaj oryginalny PDF, aż będziesz pewny, że wynik jest poprawny, ponieważ nic tutaj nie nadpisuje pliku na Twoim urządzeniu.'],
        ],
        'faqs' => [
            ['q' => 'Jak usunąć więcej niż jedną stronę naraz?', 'a' => 'Kliknij miniaturę każdej strony, aby ją oznaczyć, albo przełącz na "Zakresy stron" i wpisz coś w stylu 2, 4-6, aby oznaczyć kilka naraz.'],
            ['q' => 'Czy mogę usunąć wszystkie strony z PDF-a?', 'a' => 'Nie. Przynajmniej jedna strona musi zostać, więc przycisk Usuń strony jest wyłączony, jeśli Twój wybór usunąłby wszystkie.'],
            ['q' => 'Czy mój PDF jest gdzieś wysyłany?', 'a' => 'Nie. Strony są usuwane całkowicie w Twojej przeglądarce za pomocą JavaScript, a plik nigdy nie jest wysyłany na serwer.'],
            ['q' => 'Czy pozostałe strony tracą jakość?', 'a' => 'Nie. Zachowane strony są kopiowane dokładnie tak, jak są, bez ponownej kompresji, znaku wodnego czy dodatkowych stron.'],
        ],
    ],    'organize-pdf' => [
        'name' => 'Organizuj PDF',
        'title' => 'Organizuj PDF - Zmień Kolejność Stron Bezpłatnie',
        'description' => 'Zmień kolejność stron PDF bezpłatnie online. Przeciągnij miniatury w nowej kolejności albo użyj przycisków przesuwania. Bez wysyłania plików i rejestracji.',
        'h1' => 'Organizuj PDF',
        'tagline' => 'Przeciągnij strony w wybraną kolejność, prosto w przeglądarce.',
        'keywords' => ['organizuj pdf', 'zmiana kolejności stron pdf', 'przestawianie stron pdf', 'sortowanie stron pdf', 'zmień kolejność pdf'],
        'intro' => 'Strony czasami trafiają w niewłaściwej kolejności po skanowaniu lub połączeniu kilku dokumentów. To narzędzie organizuje PDF, pozwalając przeciągać miniatury stron w nową kolejność albo przesuwać je przyciskami strzałek, jeśli nie chcesz przeciągać. Gdy kolejność jest już właściwa, zapisz nowy PDF z przestawionymi stronami. Wszystko dzieje się na Twoim urządzeniu, więc plik nigdy nie jest wysyłany.',
        'steps' => [
            'Wybierz PDF, który chcesz przestawić.',
            'Przeciągnij miniaturę strony na nową pozycję albo użyj przycisków ← i →.',
            'Powtarzaj, aż strony będą w wybranej kolejności.',
            'Kliknij Zapisz nową kolejność i pobierz przestawiony PDF.',
        ],
        'features' => [
            'Przeciągnij i upuść miniatury, aby zmienić ich kolejność',
            'Przyciski przesuwania działają bez myszy, dla klawiatury',
            'Numery stron aktualizują się na żywo podczas przestawiania',
            'Bez znaku wodnego i bez utraty jakości',
            'Prywatność - Twój PDF nigdy nie opuszcza Twojego urządzenia',
        ],
        'content' => [
            ['heading' => 'Kiedy trzeba zmienić kolejność stron', 'body' => 'Częsty przypadek to skanowanie stosu papieru, który wychodzi w niewłaściwej kolejności, albo łączenie dwóch PDF-ów, gdzie jeden musi trafić w środek drugiego. Zamiast zaczynać od nowa, to narzędzie pozwala od razu poprawić kolejność istniejącego PDF-a.'],
            ['heading' => 'Zmiana kolejności bez myszy', 'body' => 'Każda miniatura strony ma przyciski "przesuń wcześniej" i "przesuń później", więc strony można przestawiać za pomocą klawiatury lub ekranu dotykowego tak łatwo, jak przeciąganiem.'],
        ],
        'faqs' => [
            ['q' => 'Czy mogę zmienić kolejność stron bez przeciągania?', 'a' => 'Tak. Każda miniatura ma przyciski ← i →, które przesuwają ją o jedną pozycję wcześniej lub później, i działają też z klawiatury.'],
            ['q' => 'Czy zmiana kolejności zmienia zawartość strony?', 'a' => 'Nie. Strony są kopiowane dokładnie tak, jak są; zmienia się tylko ich pozycja w dokumencie.'],
            ['q' => 'Czy mój PDF jest wysyłany na serwer?', 'a' => 'Nie. PDF jest otwierany i przestawiany całkowicie w Twojej przeglądarce za pomocą JavaScript i nigdy nie jest nigdzie wysyłany.'],
            ['q' => 'Czy mogę tu też usuwać lub obracać strony?', 'a' => 'To narzędzie tylko zmienia kolejność stron. Użyj do tego Usuń Strony PDF albo Obróć PDF, przed lub po ustawieniu kolejności.'],
        ],
    ],    'pdf-to-jpg' => [
        'name' => 'PDF na JPG',
        'title' => 'Konwerter PDF na JPG - Konwersja Stron Bezpłatnie',
        'description' => 'Konwertuj strony PDF na obrazy JPG bezpłatnie online. Wybierz 72, 150 lub 300 DPI i pobierz obraz lub ZIP. Bez wysyłania plików i rejestracji.',
        'h1' => 'PDF na JPG',
        'tagline' => 'Zmień strony PDF na obrazy JPG, prosto w przeglądarce.',
        'keywords' => ['pdf na jpg', 'konwerter pdf na jpg', 'konwertuj pdf na jpg', 'pdf na obraz', 'strona pdf na jpg'],
        'intro' => 'Konwerter PDF na JPG zmienia każdą stronę PDF-a w obraz JPG, co jest przydatne do udostępniania strony w mediach społecznościowych, wklejania do dokumentu albo przeglądania tam, gdzie PDF nie jest wspierany. Wybierz rozdzielczość 72, 150 lub 300 DPI i skonwertuj: jednostronicowy PDF pobiera się jako jeden JPG, a wielostronicowy jako ZIP z ponumerowanymi obrazami. Wszystko dzieje się na Twoim urządzeniu, więc PDF nigdy nie jest wysyłany.',
        'steps' => [
            'Wybierz PDF, który chcesz skonwertować.',
            'Wybierz jakość obrazu: 72 DPI na ekrany, 150 do ogólnego użytku albo 300 DPI do druku.',
            'Kliknij Konwertuj.',
            'Pobierz JPG albo plik ZIP, jeśli PDF ma więcej niż jedną stronę.',
        ],
        'features' => [
            'Wybierz 72, 150 lub 300 DPI',
            'Jednostronicowe PDF-y pobierają się jako jeden JPG',
            'Wielostronicowe PDF-y pobierają się jako ZIP z ponumerowanymi obrazami',
            'Miniatury potwierdzają wybór właściwego pliku',
            'Prywatność - Twój PDF nigdy nie opuszcza Twojego urządzenia',
        ],
        'content' => [
            ['heading' => 'Jakie DPI wybrać?', 'body' => '72 DPI odpowiada typowemu ekranowi i daje najmniejszy plik, dobry do szybkich podglądów lub użycia w sieci. 150 DPI to dobry ogólny wybór do udostępniania lub wklejania do dokumentów. 300 DPI daje ostrzejszy, większy obraz, odpowiedni do druku lub powiększania drobnego tekstu.'],
            ['heading' => 'PDF na JPG czy PDF na PNG', 'body' => 'JPG używa kompresji z utratą danych, co daje mniejsze pliki i pasuje do zeskanowanych stron lub zdjęć. PNG jest bezstratny i lepszy dla stron z ostrym tekstem, tabelami lub liniami, kosztem większego pliku. Użyj PDF na PNG, gdy jakość obrazu jest ważniejsza niż rozmiar pliku.'],
        ],
        'faqs' => [
            ['q' => 'Czy mogę skonwertować wszystkie strony PDF-a na JPG na raz?', 'a' => 'Tak. Konwersja przetwarza wszystkie strony; jeśli jest ich więcej niż jedna, obrazy są pakowane do jednego pliku ZIP do pobrania.'],
            ['q' => 'Jakie DPI powinienem użyć do druku?', 'a' => '300 DPI daje ostry wynik do druku. 150 DPI wystarcza do większości ekranów, a 72 DPI to najmniejszy plik, najlepszy do szybkich podglądów.'],
            ['q' => 'Czy mój PDF jest wysyłany na serwer?', 'a' => 'Nie. Strony są konwertowane na obrazy całkowicie w Twojej przeglądarce za pomocą JavaScript, a plik nigdy nie jest wysyłany na serwer.'],
            ['q' => 'Czy mogę skonwertować tylko jedną stronę, a nie cały PDF?', 'a' => 'To narzędzie konwertuje wszystkie strony. Aby otrzymać tylko jedną, najpierw użyj trybu "Wyodrębnij strony" w Dziel PDF, a potem skonwertuj tutaj powstały jednostronicowy PDF.'],
        ],
    ],
    'pdf-to-png' => [
        'name' => 'PDF na PNG',
        'title' => 'Konwerter PDF na PNG - Konwersja Stron Bezpłatnie',
        'description' => 'Konwertuj strony PDF na obrazy PNG bezpłatnie online. Wybierz 72, 150 lub 300 DPI i pobierz obraz lub ZIP. Bez wysyłania plików i rejestracji.',
        'h1' => 'PDF na PNG',
        'tagline' => 'Zmień strony PDF na ostre obrazy PNG, prosto w przeglądarce.',
        'keywords' => ['pdf na png', 'konwerter pdf na png', 'konwertuj pdf na png', 'strona pdf na png', 'pdf na obraz png'],
        'intro' => 'Konwerter PDF na PNG zmienia każdą stronę PDF-a w bezstratny obraz PNG, który zachowuje ostry tekst, tabele i rysunki liniowe. Wybierz rozdzielczość 72, 150 lub 300 DPI i skonwertuj: jednostronicowy PDF pobiera się jako jeden PNG, a wielostronicowy jako ZIP z ponumerowanymi obrazami. Wszystko dzieje się na Twoim urządzeniu, więc PDF nigdy nie jest wysyłany.',
        'steps' => [
            'Wybierz PDF, który chcesz skonwertować.',
            'Wybierz jakość obrazu: 72 DPI na ekrany, 150 do ogólnego użytku albo 300 DPI do druku.',
            'Kliknij Konwertuj.',
            'Pobierz PNG albo plik ZIP, jeśli PDF ma więcej niż jedną stronę.',
        ],
        'features' => [
            'Wybierz 72, 150 lub 300 DPI',
            'Bezstratny format PNG, ostry dla tekstu i linii',
            'Jednostronicowe PDF-y pobierają się jako jeden PNG',
            'Wielostronicowe PDF-y pobierają się jako ZIP z ponumerowanymi obrazami',
            'Prywatność - Twój PDF nigdy nie opuszcza Twojego urządzenia',
        ],
        'content' => [
            ['heading' => 'Jakie DPI wybrać?', 'body' => '72 DPI odpowiada typowemu ekranowi i daje najmniejszy plik, dobry do szybkich podglądów lub użycia w sieci. 150 DPI to dobry ogólny wybór do udostępniania lub wklejania do dokumentów. 300 DPI daje ostrzejszy, większy obraz, odpowiedni do druku lub powiększania drobnego tekstu.'],
            ['heading' => 'PDF na PNG czy PDF na JPG', 'body' => 'PNG jest bezstratny, co zachowuje ostry tekst, tabele i diagramy, kosztem większego pliku. JPG używa kompresji z utratą danych dla mniejszych plików i pasuje do zeskanowanych stron lub zdjęć. Użyj PDF na JPG, gdy rozmiar pliku jest ważniejszy niż dokładna jakość pikseli.'],
        ],
        'faqs' => [
            ['q' => 'Czemu wybrać PNG, a nie JPG?', 'a' => 'PNG jest bezstratny, dzięki czemu ostry tekst, tabele i diagramy zostają czyste bez artefaktów kompresji. Pliki JPG są zwykle mniejsze, ale mogą rozmywać drobne szczegóły.'],
            ['q' => 'Czy mogę skonwertować wszystkie strony PDF-a na PNG na raz?', 'a' => 'Tak. Konwersja przetwarza wszystkie strony; jeśli jest ich więcej niż jedna, obrazy są pakowane do jednego pliku ZIP do pobrania.'],
            ['q' => 'Czy mój PDF jest wysyłany na serwer?', 'a' => 'Nie. Strony są konwertowane na obrazy całkowicie w Twojej przeglądarce za pomocą JavaScript, a plik nigdy nie jest wysyłany na serwer.'],
            ['q' => 'Jakie DPI powinienem użyć do druku?', 'a' => '300 DPI daje ostry wynik do druku. 150 DPI wystarcza do większości ekranów, a 72 DPI to najmniejszy plik, najlepszy do szybkich podglądów.'],
        ],
    ],

    'compress-pdf' => [
        'name' => 'Kompresuj PDF',
        'title' => 'Kompresuj PDF - Zmniejsz Rozmiar Pliku za Darmo',
        'description' => 'Skompresuj PDF online za darmo, aby zmniejszyć rozmiar. Tryb Zalecany zachowuje zaznaczalny tekst; Mocny zmniejsza więcej. Bez przesyłania na serwer.',
        'h1' => 'Kompresuj PDF',
        'tagline' => 'Zmniejsz plik PDF, nie tracąc czytelności - prosto w przeglądarce.',
        'keywords' => [
            'kompresuj pdf',
            'kompresor pdf',
            'zmniejsz rozmiar pdf',
            'zmniejszanie pdf',
            'kompresuj pdf online',
        ],
        'intro' => 'Narzędzie do kompresji PDF zmniejsza rozmiar pliku PDF, redukując wielkość znajdujących się w nim obrazów, dzięki czemu łatwiej go wysłać e-mailem, przesłać lub przechowywać. Tryb Zalecany kompresuje ponownie osadzone zdjęcia w niższej jakości, zachowując ostry i zaznaczalny tekst. Tryb Mocny idzie dalej i zamienia każdą stronę w pojedynczy obraz, co daje najmniejszy możliwy plik, ale oznacza, że tekstu nie można już zaznaczyć ani wyszukać. Wszystko odbywa się na Twoim urządzeniu, więc Twój plik PDF nigdy nie trafia na serwer.',
        'steps' => [
            'Wybierz plik PDF, który chcesz skompresować.',
            'Wybierz Zalecany, aby zmniejszyć obrazy, zachowując zaznaczalny tekst, lub Mocny dla najmniejszego możliwego pliku.',
            'W trybie Mocnym wybierz jakość obrazu (DPI).',
            'Kliknij Kompresuj PDF i pobierz mniejszy plik.',
        ],
        'features' => [
            'Tryb Zalecany zachowuje zaznaczalny i przeszukiwalny tekst',
            'Tryb Mocny daje najmniejszy plik, zamieniając strony w obrazy',
            'Pokazuje rozmiar przed i po, abyś widział oszczędność',
            'Zachowuje oryginalny plik, jeśli kompresja go nie zmniejszy',
            'Prywatnie - Twój PDF nigdy nie opuszcza Twojego urządzenia',
        ],
        'content' => [
            [
                'heading' => 'Zalecany czy Mocny - który wybrać?',
                'body' => 'Tryb Zalecany kompresuje ponownie tylko zdjęcia i zeskanowane obrazy w pliku PDF, więc nagłówki, akapity i tabele pozostają dokładnie takie same i nadal można je zaznaczać, wyszukiwać i kopiować. Tryb Mocny zamienia każdą stronę w jeden obraz JPEG, co zwykle daje znacznie mniejszy plik, ale oznacza, że żadnego tekstu nie da się potem zaznaczyć, wyszukać ani skopiować - lepszy dla dokumentów pełnych zdjęć, które po prostu muszą być mniejsze do udostępnienia.',
            ],
            [
                'heading' => 'Dlaczego mój plik PDF się nie zmniejszył?',
                'body' => 'Plik PDF złożony tylko z tekstu i grafiki wektorowej, albo taki, który był już wcześniej skompresowany, może się nie zmniejszyć dalej w trybie Zalecanym, ponieważ nie zostały duże obrazy do ponownej kompresji. W takim przypadku zachowywany jest oryginalny plik, dzięki czemu nigdy nie otrzymasz cięższego wyniku niż na początku, a tryb Mocny nadal może go zmniejszyć, zamieniając strony w obrazy.',
            ],
        ],
        'faqs' => [
            [
                'q' => 'Czy kompresowanie PDF obniża jego jakość?',
                'a' => 'Tryb Zalecany nieznacznie obniża jakość osadzonych zdjęć, podobnie jak zapisanie JPEG w niższych ustawieniach, podczas gdy tekst i grafika liniowa pozostają ostre. Tryb Mocny renderuje całą stronę jako obraz, więc bardzo mały tekst może wyglądać mniej ostro po powiększeniu.',
            ],
            [
                'q' => 'Czy po kompresji nadal będę mógł zaznaczyć tekst?',
                'a' => 'Tak, w trybie Zalecanym. Tryb Mocny rasteryzuje każdą stronę do jednego obrazu, więc tekstu nie da się już zaznaczyć, wyszukać ani skopiować - wybieraj go tylko wtedy, gdy rozmiar pliku liczy się bardziej niż to.',
            ],
            [
                'q' => 'Co się stanie, jeśli skompresowany plik nie będzie mniejszy?',
                'a' => 'Oryginalny plik zostaje zachowany i udostępniony do pobrania bez zmian, więc nigdy nie otrzymasz wyniku cięższego niż to, od czego zacząłeś.',
            ],
            [
                'q' => 'Czy mój PDF jest przesyłany na serwer?',
                'a' => 'Nie. Kompresja odbywa się całkowicie w Twojej przeglądarce za pomocą JavaScript, a plik nigdy nigdzie nie jest wysyłany.',
            ],
        ],
    ],

    'protect-pdf' => [
        'name' => 'Zabezpiecz PDF',
        'title' => 'Zabezpiecz PDF - Dodaj Hasło za Darmo',
        'description' => 'Dodaj prawdziwe hasło do pliku PDF online za darmo, z szyfrowaniem AES-256. Plik otworzy tylko osoba znająca hasło. Bez przesyłania na serwer, bez rejestracji.',
        'h1' => 'Zabezpiecz PDF',
        'tagline' => 'Zablokuj plik PDF hasłem, aby mogła go otworzyć tylko osoba, która je zna.',
        'keywords' => [
            'zabezpiecz pdf',
            'hasło do pdf',
            'dodaj hasło do pdf',
            'zaszyfruj pdf',
            'hasło pdf online',
        ],
        'intro' => 'Zabezpieczenie pliku PDF dodaje hasło, dzięki któremu plik może otworzyć tylko osoba, która je zna. To narzędzie szyfruje Twój plik PDF prawdziwym szyfrowaniem AES-256, tą samą siłą, jakiej używają systemy bankowe i rządowe, bezpośrednio w przeglądarce. Wybierz hasło, potwierdź je i pobierz kopię pliku PDF, która poprosi o to hasło przed otwarciem w dowolnym czytniku PDF.',
        'steps' => [
            'Wybierz plik PDF, który chcesz zabezpieczyć.',
            'Wpisz hasło i je potwierdź.',
            'Kliknij Zabezpiecz PDF.',
            'Pobierz kopię zabezpieczoną hasłem.',
        ],
        'features' => [
            'Prawdziwe szyfrowanie AES-256, a nie tylko sztuczka z nazwą pliku',
            'Otwiera się tylko przy użyciu ustawionego przez Ciebie hasła',
            'Działa z każdym czytnikiem PDF obsługującym standardowe szyfrowanie PDF',
            'Przetwarzane całkowicie w przeglądarce - plik PDF nigdy nie jest przesyłany',
            'Bez znaku wodnego, bez limitu stron',
        ],
        'content' => [
            [
                'heading' => 'Jak silne jest to szyfrowanie?',
                'body' => 'Plik PDF jest szyfrowany algorytmem AES-256, powszechnie stosowanym do ochrony wrażliwych danych, za pomocą biblioteki open source QPDF działającej w przeglądarce jako WebAssembly. Bez hasła zawartość pliku nie może zostać odczytana przez czytnik PDF.',
            ],
            [
                'heading' => 'Co, jeśli zapomnę hasła?',
                'body' => 'Celowo nie ma możliwości odzyskania zapomnianego hasła do pliku PDF zabezpieczonego AES-256 - właśnie to czyni ochronę skuteczną. Przechowuj kopię hasła w bezpiecznym miejscu, na przykład w menedżerze haseł, i zachowaj oryginalny, niezabezpieczony plik, dopóki nie będziesz pewien, że je zapamiętasz.',
            ],
        ],
        'faqs' => [
            [
                'q' => 'Czy to przesyła mój plik PDF gdziekolwiek?',
                'a' => 'Nie. Plik jest szyfrowany całkowicie w Twojej przeglądarce za pomocą JavaScript, przy użyciu wersji QPDF skompilowanej do WebAssembly, i nigdy nie opuszcza Twojego urządzenia.',
            ],
            [
                'q' => 'Jakiego szyfrowania to używa?',
                'a' => 'AES-256, współczesnego standardu szyfrowania PDF, zastosowanego za pomocą biblioteki open source QPDF skompilowanej do działania w przeglądarce.',
            ],
            [
                'q' => 'Czy mogę później usunąć hasło?',
                'a' => 'Tak. Użyj narzędzia Odblokuj PDF z ustawionym hasłem, aby uzyskać kopię bez niego.',
            ],
            [
                'q' => 'Czy zabezpieczony plik PDF otworzy się w każdym czytniku?',
                'a' => 'Tak. Wykorzystuje standardowy format szyfrowania PDF obsługiwany przez Adobe Acrobat, przeglądarki i większość innych czytników PDF, które poproszą o hasło przed otwarciem.',
            ],
        ],
    ],

    'unlock-pdf' => [
        'name' => 'Odblokuj PDF',
        'title' => 'Odblokuj PDF - Usuń Hasło za Darmo',
        'description' => 'Usuń hasło z pliku PDF online za darmo, gdy je znasz. Wpisz hasło raz i pobierz odblokowaną kopię. Bez przesyłania na serwer, bez rejestracji.',
        'h1' => 'Odblokuj PDF',
        'tagline' => 'Usuń hasło z pliku PDF, które już znasz - prosto w przeglądarce.',
        'keywords' => [
            'odblokuj pdf',
            'usuń hasło z pdf',
            'usunąć hasło pdf',
            'odszyfruj pdf',
            'zdjęcie hasła z pdf',
        ],
        'intro' => 'Odblokowanie pliku PDF usuwa jego hasło otwierania, dzięki czemu nie jest już wymagane przy każdym otwarciu. To narzędzie usuwa wyłącznie hasło, które już znasz - wpisz je raz, a zostanie utworzona nowa kopia pliku PDF bez niego. Nie łamie, nie zgaduje ani nie omija hasła, którego nie znasz, ponieważ pozbawiłoby to sensu całą ochronę.',
        'steps' => [
            'Wybierz plik PDF zabezpieczony hasłem.',
            'Wpisz hasło.',
            'Kliknij Odblokuj PDF.',
            'Pobierz kopię bez hasła.',
        ],
        'features' => [
            'Usuwa hasło otwierania z pliku PDF, który już możesz otworzyć',
            'Nie łamie, nie zgaduje ani nie omija nieznanych haseł',
            'Działa całkowicie w Twojej przeglądarce - plik PDF nigdy nie jest przesyłany',
            'Pobierz zwykły plik PDF, który otwiera się bez pytania o nic',
            'Bez znaku wodnego, bez limitu stron',
        ],
        'content' => [
            [
                'heading' => 'Dlaczego muszę wpisać hasło?',
                'body' => 'To narzędzie odszyfrowuje plik PDF przy użyciu tego samego hasła, które już go otwiera, zamiast próbować złamać szyfrowanie. Jeśli nie znasz hasła, to narzędzie nie pomoże - nie ma wiarygodnego ani odpowiedzialnego sposobu, aby je odzyskać.',
            ],
            [
                'heading' => 'Czy to co innego niż Zabezpiecz PDF?',
                'body' => 'Zabezpiecz PDF dodaje hasło do pliku PDF, który go nie ma. Odblokuj PDF robi coś przeciwnego: usuwa hasło z pliku PDF, który już je ma, pod warunkiem że je podasz.',
            ],
        ],
        'faqs' => [
            [
                'q' => 'Czy to narzędzie może złamać lub odgadnąć hasło do pliku PDF?',
                'a' => 'Nie. Usuwa wyłącznie hasło, które sam wpisujesz. Jeśli nie znasz hasła, nie ma legalnego sposobu, aby to ani żadne inne narzędzie odzyskało je za Ciebie.',
            ],
            [
                'q' => 'Czy mój plik PDF jest gdzieś przesyłany?',
                'a' => 'Nie. Hasło jest sprawdzane i usuwane całkowicie w Twojej przeglądarce przy użyciu wersji biblioteki open source QPDF skompilowanej do WebAssembly, a plik nigdy nie opuszcza Twojego urządzenia.',
            ],
            [
                'q' => 'Co się stanie, jeśli wpiszę złe hasło?',
                'a' => 'Zobaczysz komunikat „Nieprawidłowe hasło" i będziesz mógł spróbować ponownie. Sam plik nigdy nie zostaje zmieniony, dopóki prawidłowe hasło pomyślnie go nie odblokuje.',
            ],
            [
                'q' => 'Czy odblokowanie zmienia coś jeszcze w pliku PDF?',
                'a' => 'Nie. Usuwana jest tylko ochrona hasłem; strony, tekst i obrazy pozostają dokładnie takie same.',
            ],
        ],
    ],

    'pdf-to-word' => [
        'name' => 'PDF do Worda',
        'title' => 'Konwerter PDF do Worda - Darmowy i Prywatny',
        'description' => 'Konwertuj PDF do Worda online za darmo. Tekst, akapity i nagłówki stają się edytowalnym plikiem .docx tworzonym w przeglądarce, bez rejestracji.',
        'h1' => 'Konwerter PDF do Worda',
        'tagline' => 'Zamień PDF w edytowalny dokument Word, bezpośrednio w przeglądarce.',
        'keywords' => [
            'pdf do worda',
            'konwertuj pdf do worda',
            'konwerter pdf do worda',
            'pdf do docx',
            'pdf do worda online za darmo',
        ],
        'intro' => 'Konwerter PDF do Worda zmienia tekst z PDF-a w edytowalny plik .docx, który można otworzyć w Microsoft Word, Google Docs albo LibreOffice. To narzędzie odczytuje tekst z Twojego PDF-a i odtwarza go jako akapity i nagłówki, dzięki czemu możesz edytować treść bez przepisywania jej od nowa. PDF jest odczytywany w całości w Twojej przeglądarce i nigdy nie jest wysyłany na żaden serwer.',
        'steps' => [
            'Wybierz albo upuść PDF, który chcesz przekonwertować.',
            'Kliknij Konwertuj do Worda.',
            'Pobierz plik .docx i otwórz go w Wordzie, Google Docs albo LibreOffice.',
        ],
        'features' => [
            'Wyodrębnia tekst w naprawdę edytowalne akapity',
            'Wykrywa nagłówki na podstawie rozmiaru czcionki, w sposób orientacyjny',
            'Zachowuje podziały wiersza i kolejność czytania',
            'Prywatne: PDF nigdy nie jest wysyłany',
            'Bez rejestracji, bez znaku wodnego',
        ],
        'content' => [
            [
                'heading' => 'Co jest konwertowane, a co nie',
                'body' => 'PDF nie ma prawdziwej struktury akapitów, tabel czy nagłówków - jest w nim tylko tekst umieszczony na stronie. To narzędzie odtwarza akapity i nagłówki na podstawie tego tekstu, co dobrze działa w prostych dokumentach, takich jak listy, raporty i artykuły. Tabele, układy wielokolumnowe, pola tekstowe, obrazy oraz dokładne czcionki czy odstępy nie są zachowywane - wynikiem jest czytelny, edytowalny dokument, a nie piksel po pikselu identyczna kopia.',
            ],
            [
                'heading' => 'Czemu zeskanowanego PDF-a nie można przekonwertować?',
                'body' => 'Zeskanowany PDF to w rzeczywistości zdjęcie strony, bez leżącego pod nim tekstu, który można zaznaczyć i który przeglądarka mogłaby odczytać. Konwersja wymagałaby najpierw OCR (optycznego rozpoznawania znaków), czego to narzędzie nie robi; jeśli w Twoim czytniku PDF można zaznaczyć i skopiować tekst, konwersja powinna zadziałać normalnie.',
            ],
        ],
        'faqs' => [
            ['q' => 'Czy formatowanie będzie identyczne jak w oryginalnym PDF-ie?', 'a' => 'Nie dokładnie. Tekst, podstawowe nagłówki i podziały wiersza są zachowywane, ale tabele, kolumny, obrazy oraz dokładne czcionki czy odstępy nie. Celem jest edytowalny tekst, a nie piksel po pikselu identyczna kopia.'],
            ['q' => 'Czy mogę przekonwertować zeskanowany PDF?', 'a' => 'Tylko jeśli ma już tekst, który można zaznaczyć. Zeskanowana strona bez warstwy tekstu nie ma nic, co to narzędzie mogłoby wyodrębnić, ponieważ nie wykonuje OCR.'],
            ['q' => 'Czy mój PDF jest gdzieś wysyłany?', 'a' => 'Nie. Cała konwersja odbywa się w Twojej przeglądarce za pomocą JavaScript, a plik nigdy nie opuszcza Twojego urządzenia.'],
            ['q' => 'Jaki plik otrzymam?', 'a' => 'Standardowy plik .docx, który otwiera się w Microsoft Word, Google Docs, LibreOffice Writer i większości innych programów do edycji tekstu.'],
        ],
    ],

    'word-to-pdf' => [
        'name' => 'Word do PDF',
        'title' => 'Konwerter Worda do PDF - Darmowy i Prywatny',
        'description' => 'Konwertuj Worda (.docx) do PDF online za darmo. Zachowuje nagłówki, akapity, listy, pogrubienie/kursywę i obrazy - w całości w Twojej przeglądarce.',
        'h1' => 'Konwerter Worda do PDF',
        'tagline' => 'Zamień dokument Word w PDF, prywatnie w Twojej przeglądarce.',
        'keywords' => [
            'word do pdf',
            'konwertuj word do pdf',
            'docx do pdf',
            'konwerter word do pdf',
            'word do pdf online za darmo',
        ],
        'intro' => 'Konwersja Worda do PDF zmienia edytowalny plik .docx w stały PDF, który wygląda tak samo na każdym urządzeniu i nie da się go łatwo edytować. To narzędzie odczytuje Twój dokument Word i odtwarza jego nagłówki, akapity, listy, tekst pogrubiony lub kursywą oraz obrazy jako nowy PDF - wszystko w Twojej przeglądarce. Dokument nigdzie nie jest wysyłany.',
        'steps' => [
            'Wybierz albo upuść plik Word (.docx), który chcesz przekonwertować.',
            'Wybierz rozmiar strony A4 albo Letter.',
            'Kliknij Konwertuj do PDF i pobierz wynik.',
        ],
        'features' => [
            'Zachowuje nagłówki, akapity i podziały wiersza',
            'Zachowuje listy wypunktowane i numerowane',
            'Zachowuje tekst pogrubiony i kursywą',
            'Zachowuje obrazy z dokumentu',
            'Prywatne: Twój dokument nigdy nie jest wysyłany',
        ],
        'content' => [
            [
                'heading' => 'Co jest zachowywane, a co nie',
                'body' => 'Nagłówki, akapity, podziały wiersza, listy wypunktowane i numerowane, tekst pogrubiony i kursywą oraz większość obrazów są odtwarzane w PDF-ie. Tabele, układy wielokolumnowe, pola tekstowe, nagłówki i stopki stron, śledzenie zmian oraz dokładne czcionki czy pozycjonowanie z oryginalnego dokumentu Word nie są zachowywane - wynik zachowuje treść i kolejność czytania, a nie odtwarza stronę piksel po pikselu.',
            ],
            [
                'heading' => 'Obsługiwane są tylko pliki .docx',
                'body' => 'To narzędzie odczytuje nowoczesny format Worda (.docx). Starszy format .doc z Worda 2003 i wcześniejszych nie jest obsługiwany; otwórz go w Wordzie i użyj „Zapisz jako”, aby najpierw utworzyć kopię .docx.',
            ],
        ],
        'faqs' => [
            ['q' => 'Czy mój dokument Word będzie wyglądał identycznie w PDF-ie?', 'a' => 'Nagłówki, akapity, listy, pogrubienie/kursywa i obrazy są zachowywane, ale tabele, kolumny, pola tekstowe oraz dokładne czcionki czy odstępy nie. W większości listów, raportów i artykułów wynik jest bardzo zbliżony do oryginału.'],
            ['q' => 'Czy to działa z plikami .doc?', 'a' => 'Nie, tylko z nowoczesnym formatem .docx. Starsze pliki .doc trzeba najpierw zapisać jako .docx w Wordzie.'],
            ['q' => 'Czy mój dokument jest gdzieś wysyłany?', 'a' => 'Nie. Cała konwersja odbywa się w Twojej przeglądarce za pomocą JavaScript, a plik nigdy nie opuszcza Twojego urządzenia.'],
            ['q' => 'Jakiego rozmiaru strony używa PDF?', 'a' => 'Wybierz A4 albo Letter przed konwersją; treść jest dopasowywana do wybranej strony.'],
        ],
    ],

    'excel-to-pdf' => [
        'name' => 'Excel do PDF',
        'title' => 'Konwerter Excela do PDF - Darmowy i Prywatny',
        'description' => 'Konwertuj Excel (.xlsx, .xls) albo CSV do PDF online za darmo. Każdy arkusz staje się czytelną, podzieloną na strony tabelą, w całości w przeglądarce.',
        'h1' => 'Konwerter Excela do PDF',
        'tagline' => 'Zamień arkusz kalkulacyjny w czytelną, podzieloną na strony tabelę PDF.',
        'keywords' => [
            'excel do pdf',
            'konwertuj excel do pdf',
            'xlsx do pdf',
            'arkusz kalkulacyjny do pdf',
            'csv do pdf',
        ],
        'intro' => 'Konwerter Excela do PDF zmienia arkusz kalkulacyjny w stały dokument, który otwiera się tak samo na każdym urządzeniu, bez potrzeby zainstalowanego Excela. To narzędzie odczytuje Twój plik .xlsx, .xls albo .csv i rysuje każdy arkusz jako tabelę z obramowaniem, dzieląc go na tyle stron, ile potrzeba, z powtórzonym wierszem nagłówka na każdej stronie. Plik jest odczytywany w całości w Twojej przeglądarce i nigdy nie jest wysyłany.',
        'steps' => [
            'Wybierz albo upuść swój plik Excel (.xlsx, .xls) albo CSV.',
            'Wybierz rozmiar strony i orientację (pionową albo poziomą).',
            'Kliknij Konwertuj do PDF i pobierz wynik.',
        ],
        'features' => [
            'Konwertuje pliki .xlsx, .xls i .csv',
            'Każdy arkusz staje się własną tabelą, z nagłówkiem powtórzonym na każdej stronie',
            'Pionowa albo pozioma, A4 albo Letter',
            'Kolumny automatycznie dopasowują się do treści',
            'Prywatne: Twój arkusz nigdy nie jest wysyłany',
        ],
        'content' => [
            [
                'heading' => 'Jak szeroki arkusz wygląda w PDF-ie',
                'body' => 'Kolumny dopasowują się do swojej treści i są zmniejszane, aby zmieścić się w szerokości strony, gdy to możliwe. Jeśli arkusz wciąż ma zbyt wiele kolumn, tekst, który nie mieści się w swojej kolumnie, jest skracany wielokropkiem („…”) zamiast nakładać się na następną kolumnę. Przełączenie na orientację poziomą zwykle daje szerokim arkuszom więcej miejsca.',
            ],
            [
                'heading' => 'Co nie jest zachowywane',
                'body' => 'To narzędzie skupia się na tym, aby dane były czytelne na stronie: kolory tła komórek, własne czcionki, formuły (zamiast nich używana jest ostatnia obliczona wartość), wykresy i scalone komórki nie są zachowywane.',
            ],
        ],
        'faqs' => [
            ['q' => 'Czy mogę przekonwertować też plik CSV?', 'a' => 'Tak. Pliki CSV działają tak samo jak .xlsx i .xls: wybierz plik, a stanie się jednostronicową tabelą PDF.'],
            ['q' => 'Co się dzieje z arkuszem mającym dużo kolumn?', 'a' => 'Szerokość kolumn jest zmniejszana, aby zmieściła się na stronie, a przełączenie na orientację poziomą daje szerokim tabelom więcej miejsca. Tekst, który wciąż nie mieści się w swojej kolumnie, jest skracany znakiem „…”.'],
            ['q' => 'Czy formuły albo wykresy są zachowywane?', 'a' => 'Formuły pokazują swoją ostatnią obliczoną wartość jako tekst, nie samą formułę, a wykresy nie są umieszczane w PDF-ie.'],
            ['q' => 'Czy mój arkusz jest gdzieś wysyłany?', 'a' => 'Nie. Cała konwersja odbywa się w Twojej przeglądarce za pomocą JavaScript, a plik nigdy nie opuszcza Twojego urządzenia.'],
        ],
    ],

    'pdf-to-excel' => [
        'name' => 'PDF do Excela',
        'title' => 'Konwerter PDF do Excela - Darmowy i Prywatny',
        'description' => 'Konwertuj PDF do Excela online za darmo. Tekst jest grupowany w wiersze i kolumny w sposób orientacyjny, w pliku .xlsx tworzonym w przeglądarce.',
        'h1' => 'Konwerter PDF do Excela',
        'tagline' => 'Zamień tabele z PDF-a w arkusz kalkulacyjny, w sposób orientacyjny.',
        'keywords' => [
            'pdf do excela',
            'konwertuj pdf do excela',
            'pdf do xlsx',
            'pdf do arkusza kalkulacyjnego',
            'tabela pdf do excela',
        ],
        'intro' => 'PDF nie ma prawdziwych wierszy czy kolumn - jest w nim tylko tekst umieszczony na stronie, więc zamiana go w arkusz kalkulacyjny jest zawsze oszacowaniem. To narzędzie grupuje tekst, który ma tę samą pozycję pionową, w jeden wiersz, a następnie dopasowuje podobne pozycje poziome na stronie w kolumny i zapisuje wynik jako plik .xlsx z jednym arkuszem na stronę. Działa najlepiej na PDF-ach, które już wyglądają jak tabela, na przykład fakturach albo wyeksportowanych raportach, i jest odczytywany w całości w Twojej przeglądarce.',
        'steps' => [
            'Wybierz albo upuść PDF, który chcesz przekonwertować.',
            'Kliknij Konwertuj do Excela.',
            'Pobierz plik .xlsx i otwórz go w Excelu, Google Sheets albo LibreOffice Calc.',
        ],
        'features' => [
            'Automatycznie grupuje tekst w wiersze i kolumny',
            'Jeden arkusz na każdą stronę PDF-a',
            'Dobrze działa na fakturach i już tabelarycznych wyeksportowanych raportach',
            'Prywatne: PDF nigdy nie jest wysyłany',
            'Bez rejestracji, bez znaku wodnego',
        ],
        'content' => [
            [
                'heading' => 'Kiedy to dobrze działa, a kiedy nie',
                'body' => 'PDF-y, które już wyglądają jak tabela (faktury, wyciągi bankowe, wyeksportowane raporty z wyraźnymi kolumnami), są dobrze konwertowane, ponieważ ich tekst równo układa się w wiersze i kolumny. Swobodny tekst, na przykład z listów czy artykułów, nie ma prawdziwych kolumn do wykrycia, więc często trafia do jednej kolumny. Scalone komórki, komórki z wieloma wierszami oraz zeskanowane (same obrazy) strony nie są obsługiwane.',
            ],
            [
                'heading' => 'Czemu zeskanowany PDF się nie przekonwertuje',
                'body' => 'Zeskanowany PDF to zdjęcie strony bez leżącego pod nim tekstu, który można zaznaczyć, więc nie ma nic, co to narzędzie mogłoby odczytać. Konwersja skanu wymaga najpierw OCR (optycznego rozpoznawania znaków), czego to narzędzie nie robi; jeśli możesz zaznaczyć i skopiować tekst w swoim czytniku PDF, konwersja powinna zadziałać.',
            ],
        ],
        'faqs' => [
            ['q' => 'Czy kolumny ułożą się idealnie?', 'a' => 'Na PDF-ach, które już wyglądają jak tabela, zwykle tak. Na swobodnym tekście nie ma prawdziwych kolumn do wykrycia, więc wyniki są dużo mniej wiarygodne - to zawsze orientacyjne wyodrębnianie, a nie precyzyjny czytnik tabel.'],
            ['q' => 'Czy mogę przekonwertować zeskanowany PDF?', 'a' => 'Tylko jeśli ma już tekst, który można zaznaczyć. Zeskanowana strona bez warstwy tekstu nie ma nic, co to narzędzie mogłoby wyodrębnić, ponieważ nie wykonuje OCR.'],
            ['q' => 'Jak obsługiwane są wielostronicowe pliki?', 'a' => 'Każda strona PDF-a staje się własnym arkuszem w skoroszycie, nazwanym „Page 1”, „Page 2” i tak dalej.'],
            ['q' => 'Czy mój PDF jest gdzieś wysyłany?', 'a' => 'Nie. Cała konwersja odbywa się w Twojej przeglądarce za pomocą JavaScript, a plik nigdy nie opuszcza Twojego urządzenia.'],
        ],
    ],

    'html-to-pdf' => [
        'name' => 'HTML do PDF',
        'title' => 'Konwerter HTML do PDF - Darmowy i Prywatny',
        'description' => 'Konwertuj HTML albo zwykły tekst do PDF online za darmo. Wklej kod albo tekst i pobierz PDF z nagłówkami, listami i formatowaniem, w przeglądarce.',
        'h1' => 'Konwerter HTML do PDF',
        'tagline' => 'Wklej HTML albo zwykły tekst i pobierz go jako PDF.',
        'keywords' => [
            'html do pdf',
            'konwertuj html do pdf',
            'konwerter html do pdf',
            'tekst do pdf',
            'html do pdf online za darmo',
        ],
        'intro' => 'Ten konwerter HTML do PDF zamienia wklejony HTML, albo po prostu zwykły tekst, w PDF do pobrania. Rozumie typowe tagi, takie jak nagłówki, akapity, podziały wiersza, listy, tekst pogrubiony i kursywą oraz obrazy, i układa je na stronach A4 albo Letter. Nigdy nie pobiera innej strony internetowej - używany jest tylko wklejony przez Ciebie HTML albo tekst, a PDF powstaje w całości w Twojej przeglądarce.',
        'steps' => [
            'Wklej HTML albo zwykły tekst w polu.',
            'Wybierz rozmiar strony A4 albo Letter.',
            'Kliknij Konwertuj do PDF i pobierz wynik.',
        ],
        'features' => [
            'Obsługuje nagłówki, akapity i podziały wiersza',
            'Obsługuje listy wypunktowane i numerowane',
            'Obsługuje tekst pogrubiony i kursywą',
            'Obsługuje obrazy podane jako adresy data:',
            'Nigdy nie pobiera innych stron internetowych - używana jest tylko Twoja wklejona treść',
        ],
        'content' => [
            [
                'heading' => 'Jaki HTML jest obsługiwany',
                'body' => 'Nagłówki (h1-h6), akapity, podziały wiersza, listy wypunktowane i numerowane, tekst pogrubiony/strong i kursywą/em oraz obrazy podane jako adresy data: są układane w PDF-ie. Tagi, których to narzędzie nie rozumie konkretnie, takie jak tabele, linki czy własne style, są ignorowane, ale tekst w nich zostaje zachowany, dzięki czemu nic nie jest po cichu tracone.',
            ],
            [
                'heading' => 'Czemu nie można pobrać obrazów albo stron z adresu URL?',
                'body' => 'To narzędzie nigdy nie wysyła żądań sieciowych w Twoim imieniu, więc tag <img src="https://..."> wskazujący na inną stronę internetową się nie pojawi - widoczne są tylko obrazy już osadzone jako adresy data:. Dzięki temu narzędzie pozostaje prywatne i nigdy nie kontaktuje żadnej strony bez Twojego bezpośredniego działania.',
            ],
        ],
        'faqs' => [
            ['q' => 'Czy mogę przekonwertować zwykły tekst, nie tylko HTML?', 'a' => 'Tak. Tekst bez żadnych tagów jest traktowany jako jeden akapit, więc możesz wkleić zwykły tekst bezpośrednio.'],
            ['q' => 'Czy moje style CSS i kolory zostaną zachowane?', 'a' => 'Nie. To narzędzie skupia się na strukturze i czytelnej treści - nagłówkach, akapitach, listach, pogrubieniu/kursywie i obrazach - a nie na dokładnych kolorach, czcionkach czy układzie CSS.'],
            ['q' => 'Czy może przekonwertować stronę internetową z adresu URL?', 'a' => 'Nie, tylko HTML albo tekst, który sam wklejesz. Nigdy nie pobiera innych stron internetowych, co zachowuje prywatność i przewidywalność.'],
            ['q' => 'Czy moja wklejona treść jest gdzieś wysyłana?', 'a' => 'Nie. Cała konwersja odbywa się w Twojej przeglądarce za pomocą JavaScript, a nic z tego, co wklejasz, nigdy nie opuszcza Twojego urządzenia.'],
        ],
    ],

    'sign-pdf' => [
        'name' => 'Podpisz PDF',
        'title' => 'Podpisz PDF Online Bezpłatnie - Dodaj Podpis',
        'description' => 'Podpisz PDF bezpłatnie online. Narysuj, wpisz lub wgraj podpis i umieść go na stronie. Podpis elektroniczny, nie certyfikat. Bez wgrywania plików.',
        'h1' => 'Podpisz PDF',
        'tagline' => 'Narysuj, wpisz lub wgraj swój podpis i umieść go na każdej stronie - prosto w przeglądarce.',
        'keywords' => ['podpisz pdf', 'podpisz pdf online', 'podpis pdf', 'elektroniczny podpis pdf', 'dodaj podpis do pdf'],
        'intro' => 'To narzędzie do podpisywania PDF dodaje Twój podpis do dokumentu bez drukowania, skanowania czy instalowania czegokolwiek. Narysuj go myszką lub palcem, wpisz swoje imię i nazwisko czcionką przypominającą podpis albo wgraj zdjęcie swojego podpisu, a potem przeciągnij go na wybrane miejsce na dowolnej stronie i pobierz podpisany plik. Powstaje podpis elektroniczny - obraz umieszczony na stronie - a nie podpis cyfrowy oparty na certyfikacie, a wszystko dzieje się na Twoim urządzeniu.',
        'steps' => [
            'Wybierz PDF, który chcesz podpisać.',
            'Narysuj, wpisz lub wgraj swój podpis.',
            'Kliknij „Dodaj podpis do tej strony", a potem przeciągnij go lub zmień jego rozmiar.',
            'Zmień stronę, aby dodać podpis ponownie, jeśli musisz podpisać więcej niż jedną stronę.',
            'Opcjonalnie zaznacz „Dodaj dzisiejszą datę", a potem kliknij Podpisz PDF i pobierz plik.',
        ],
        'features' => [
            'Rysuj myszką lub palcem, wpisuj tekst albo wgraj obraz podpisu',
            'Przeciągaj i zmieniaj rozmiar podpisu na każdej stronie',
            'Podpisz kilka stron w jednym PDF',
            'Opcjonalna data pod podpisem',
            'Prywatność - Twój PDF i podpis nigdy nie opuszczają Twojego urządzenia',
        ],
        'content' => [
            ['heading' => 'Jaki to rodzaj podpisu?', 'body' => 'To narzędzie tworzy podpis elektroniczny: obraz Twojego narysowanego, wpisanego lub wgranego podpisu umieszczony na stronie, tak jak podpisałbyś odręcznie wydrukowany formularz. Nie jest to podpis cyfrowy oparty na certyfikacie, zabezpieczony kluczem publicznym i weryfikacją tożsamości, i nie dodaje do pliku żadnego dowodu kryptograficznego. Do codziennych ustaleń to zwykle wystarcza, ale sprawdź, czego wymaga konkretna umowa lub urząd, zanim oprzesz na nim coś prawnie istotnego.'],
            ['heading' => 'Jak uzyskać czysto wyglądający podpis', 'body' => 'Rysuj powoli i trochę większy niż potrzebujesz - podpis można potem zmniejszyć lub powiększyć bez utraty szczegółów. Jeśli wgrywasz zdjęcie swojego podpisu, zadbaj o dobre światło i jednolite białe tło, a potem dokładnie je przycinaj; PNG z przezroczystym tłem najbardziej naturalnie wkomponowuje się w treść strony.'],
        ],
        'faqs' => [
            ['q' => 'Czy to prawnie wiążący podpis cyfrowy?', 'a' => 'To narzędzie tworzy podpis elektroniczny - obraz podpisu umieszczony na PDF - a nie podpis cyfrowy oparty na certyfikacie z weryfikacją tożsamości. Wiele codziennych umów akceptuje podpisy elektroniczne, ale w sprawach prawnie istotnych sprawdź najpierw, czego wymaga druga strona lub właściwy urząd.'],
            ['q' => 'Czy mogę podpisać więcej niż jedną stronę?', 'a' => 'Tak. Przejdź do innej strony za pomocą nawigacji stron i kliknij ponownie „Dodaj podpis do tej strony"; każdy umieszczony podpis można przesuwać i zmieniać jego rozmiar niezależnie.'],
            ['q' => 'Czy mój PDF i podpis są gdzieś wysyłane?', 'a' => 'Nie. PDF jest otwierany, podpisywany i zapisywany całkowicie w Twojej przeglądarce za pomocą JavaScript, a nic nie jest wysyłane na serwer.'],
            ['q' => 'Czy mogę przesunąć, zmienić rozmiar lub usunąć podpis po jego umieszczeniu?', 'a' => 'Tak. Przeciągnij, aby go przesunąć, przeciągnij uchwyt w rogu, aby zmienić rozmiar, albo kliknij przycisk ×, aby go usunąć - wszystko przed kliknięciem Podpisz PDF.'],
            ['q' => 'Jakie formaty obrazów mogę wgrać jako podpis?', 'a' => 'PNG, JPG i WebP. PNG z przezroczystym tłem zwykle wygląda najlepiej, bo nie zakrywa treści strony białym prostokątem.'],
        ],
    ],

    'redact-pdf' => [
        'name' => 'Zaczernij PDF',
        'title' => 'Zaczernij PDF Online Bezpłatnie - Usuń Tekst',
        'description' => 'Zaczernij PDF bezpłatnie online. Narysuj pola nad tekstem lub obrazami, aby usunąć je na stałe - prawdziwa redakcja, nie tylko czarny prostokąt.',
        'h1' => 'Zaczernij PDF',
        'tagline' => 'Narysuj pole nad tym, co trzeba ukryć, i usuń to na zawsze - prosto w przeglądarce.',
        'keywords' => ['zaczernij pdf', 'redakcja pdf online', 'usuń tekst z pdf', 'zaciemnij tekst pdf', 'narzędzie do redakcji pdf'],
        'intro' => 'Zaczernienie PDF oznacza trwałe usunięcie wrażliwego tekstu lub obrazów, a nie tylko ich zakrycie. Narysuj pole nad tym, co trzeba ukryć - nazwiskiem, numerem konta, zdjęciem - a to narzędzie odbuduje tę stronę jako spłaszczony obraz, dzięki czemu oryginalna zawartość pod spodem naprawdę znika i nie można jej skopiować, wyszukać ani odzyskać. Strony, których nie zaznaczysz, zachowują swój prawdziwy, zaznaczalny tekst. Wszystko dzieje się w przeglądarce; plik nigdy nie jest wysyłany.',
        'steps' => [
            'Wybierz PDF, który chcesz zaczernić.',
            'Narysuj pole nad tym, co chcesz trwale usunąć ze strony.',
            'Dodaj więcej pól na tej stronie lub zmień stronę, aby zaczernić więcej.',
            'Kliknij Zaczernij PDF i pobierz plik.',
        ],
        'features' => [
            'Rysuj pola bezpośrednio na podglądzie strony',
            'Prawdziwa redakcja: zaznaczone strony są spłaszczane do obrazów',
            'Strony bez pola zachowują swój prawdziwy, zaznaczalny tekst',
            'Przesuń, zmień rozmiar lub usuń pole przed zaczernieniem',
            'Prywatność - Twój PDF nigdy nie opuszcza Twojego urządzenia',
        ],
        'content' => [
            ['heading' => 'Dlaczego sam czarny prostokąt nie wystarczy', 'body' => 'Narysowanie czarnego prostokąta na PDF w wielu edytorach zakrywa tekst tylko wizualnie - prawdziwy tekst nadal znajduje się w pliku pod spodem i można go skopiować, wyszukać lub wydobyć odpowiednim narzędziem. To narzędzie zamiast tego zamienia każdą zaznaczoną stronę w spłaszczony obraz, dzięki czemu oryginalny tekst i zawartość wektorowa tej strony są całkowicie odrzucane, a nie tylko ukryte za kształtem.'],
            ['heading' => 'Co się zmienia na zaczernionej stronie', 'body' => 'Gdy zaczernisz choć jedno miejsce na stronie, cała strona staje się obrazem: to, co widzisz, jest dokładnie tym, co zostaje, ale żaden tekst nie da się już zaznaczyć, wyszukać ani skopiować, nawet poza zaznaczonymi obszarami. Strony, których nie zaznaczasz, pozostają całkowicie nietknięte, z oryginalnym tekstem i jakością.'],
        ],
        'faqs' => [
            ['q' => 'Czy to naprawdę usuwa tekst, czy tylko ukrywa go pod polem?', 'a' => 'Naprawdę go usuwa. Każda strona z co najmniej jednym polem redakcji jest zamieniana w obraz, który zastępuje stronę, więc oryginalny tekst i cała zawartość pod polem lub wokół niego znika z pliku - a nie jest tylko zakryta.'],
            ['q' => 'Czy strony bez pola redakcji nadal będą miały zaznaczalny tekst?', 'a' => 'Tak. Tylko zaznaczone strony stają się obrazami; wszystkie pozostałe zachowują oryginalny tekst, obrazy i jakość bez zmian.'],
            ['q' => 'Czy mogę przesunąć lub zmienić rozmiar pola przed zaczernieniem?', 'a' => 'Tak. Przeciągnij pole, aby je przesunąć, przeciągnij uchwyt w rogu, aby zmienić rozmiar, albo kliknij przycisk ×, aby je usunąć - wszystko przed kliknięciem Zaczernij PDF.'],
            ['q' => 'Czy mój PDF jest wysyłany na serwer?', 'a' => 'Nie. Cały proces redakcji, łącznie ze zamianą strony w obraz, odbywa się w Twojej przeglądarce za pomocą JavaScript, a nic nie jest nigdzie wysyłane.'],
            ['q' => 'Dlaczego zaczernione strony wyglądają nieco inaczej niż oryginał?', 'a' => 'Ponieważ są teraz obrazami zamiast prawdziwego tekstu i grafiki wektorowej, bardzo drobny tekst lub cienkie linie mogą wyglądać nieco mniej ostro przy dużym przybliżeniu - to cena za pewność, że nic pod spodem nie da się odzyskać.'],
        ],
    ],

    'edit-pdf' => [
        'name' => 'Edytuj PDF',
        'title' => 'Edytuj PDF Online Bezpłatnie - Dodaj Tekst',
        'description' => 'Edytuj PDF bezpłatnie online. Dodaj tekst, obrazy, zakreślenia i rysunki na dowolnej stronie. Dodaje treść, nie edytuje istniejącego tekstu. Bez wgrywania.',
        'h1' => 'Edytuj PDF',
        'tagline' => 'Dodaj tekst, obrazy, zakreślenia i odręczne rysunki na dowolnej stronie - prosto w przeglądarce.',
        'keywords' => ['edytuj pdf', 'edytuj pdf online', 'dodaj tekst do pdf', 'adnotacje w pdf', 'darmowy edytor pdf'],
        'intro' => 'Ten edytor PDF pozwala dodać nowy tekst, własne obrazy, zakreślone fragmenty i odręczne rysunki na dowolnej stronie, a następnie zapisać wynik. Wybierz, co dodać, umieść to tam, gdzie trzeba, przeciągnij lub zmień rozmiar, i cofnij, jeśli zmienisz zdanie. Narzędzie dodaje nową treść na stronie - tak jak pisanie na wydrukowanej kartce - zamiast edytować tekst, który już jest w PDF. Wszystko dzieje się w przeglądarce; plik nigdy nie jest wysyłany.',
        'steps' => [
            'Wybierz PDF, który chcesz edytować.',
            'Wybierz Tekst, Obraz, Zakreślenie lub Rysunek i ustaw rozmiar lub kolor.',
            'Kliknij „Dodaj ... do strony", a potem przeciągnij, zmień rozmiar lub usuń.',
            'Zmień stronę lub dodaj więcej elementów - Cofnij usuwa ostatni, jeśli zmienisz zdanie.',
            'Kliknij Zapisz PDF i pobierz plik.',
        ],
        'features' => [
            'Dodaj tekst w dowolnym rozmiarze i kolorze',
            'Dodaj własne obrazy',
            'Zakreśl dowolną część strony',
            'Rysuj odręcznie myszką lub palcem',
            'Cofnij ostatnią zmianę lub usuń dowolny element osobno',
        ],
        'content' => [
            ['heading' => 'Co to narzędzie potrafi, a czego nie', 'body' => 'Wszystko, co dodajesz - tekst, obrazy, zakreślenia, rysunki - ląduje na stronie jako nowa treść. To narzędzie nie może zaznaczyć, przesunąć ani zmienić tekstu, który już był w PDF; dodaje tylko nowe elementy na tym, co już istnieje, tak jak przyklejenie karteczki lub wydrukowanej etykiety na papierowym dokumencie.'],
            ['heading' => 'Dobre zastosowania dodawania treści do PDF', 'body' => 'Dodaj notatkę, pieczątkę, parafkę, zakreślony fragment, zaznaczony okręgiem szczegół albo strzałkę wskazującą coś - przydatne do opisywania dokumentu, przeglądania wersji roboczej albo wypełnienia prostego pola formularza, którego jeszcze nie ma. Aby zmienić tekst już obecny w dokumencie, potrzebny jest oryginalny plik źródłowy.'],
        ],
        'faqs' => [
            ['q' => 'Czy mogę edytować tekst, który już jest w PDF?', 'a' => 'Nie. To narzędzie dodaje tylko nowy tekst, obrazy, zakreślenia i rysunki na stronie; nie może zaznaczyć ani zmienić tekstu, który już tam był. Traktuj to jako dopisanie czegoś do wydrukowanej strony, a nie otwieranie edytora tekstu.'],
            ['q' => 'Czy mogę cofnąć błąd?', 'a' => 'Tak. Kliknij Cofnij, aby usunąć ostatnio dodany element, albo kliknij × na dowolnym elemencie, aby usunąć akurat ten - wszystko przed kliknięciem Zapisz PDF.'],
            ['q' => 'Czy mogę przesunąć lub zmienić rozmiar tego, co dodałem/am?', 'a' => 'Tak. Przeciągnij dowolny tekst, obraz lub zakreślenie, aby go przesunąć; obrazy i zakreślenia mają też uchwyt w rogu do zmiany rozmiaru. Odręczne rysunki też można przeciągać.'],
            ['q' => 'Czy mój PDF jest wysyłany na serwer?', 'a' => 'Nie. Wszystko - dodawanie, przesuwanie, zmiana rozmiaru i zapisywanie - odbywa się w Twojej przeglądarce za pomocą JavaScript, a nic nie jest nigdzie wysyłane.'],
            ['q' => 'Jakie formaty obrazów mogę dodać?', 'a' => 'PNG, JPG i WebP.'],
        ],
    ],

    'mortgage-calculator' => [
        'name' => 'Kalkulator kredytu hipotecznego',
        'title' => 'Kalkulator Kredytu Hipotecznego - Rata i Harmonogram Spłat',
        'description' => 'Darmowy kalkulator kredytu hipotecznego: podaj cenę, wkład własny, oprocentowanie i okres, aby zobaczyć ratę, odsetki i harmonogram spłat.',
        'h1' => 'Kalkulator kredytu hipotecznego',
        'tagline' => 'Sprawdź ratę miesięczną, łączne odsetki i harmonogram spłat rok po roku.',
        'keywords' => [
            'kalkulator kredytu hipotecznego',
            'kalkulator raty kredytu',
            'kalkulator kredytu mieszkaniowego',
            'kalkulator harmonogramu spłat',
            'kalkulator kredytu hipotecznego z nadpłatą',
        ],
        'intro' => 'Kalkulator kredytu hipotecznego wylicza miesięczną ratę kapitałowo-odsetkową kredytu na podstawie ceny nieruchomości, wkładu własnego, oprocentowania i okresu kredytowania. Podaj swoje dane poniżej, aby zobaczyć ratę miesięczną, łączne odsetki zapłacone przez cały okres kredytu oraz pełny harmonogram spłat rok po roku, pokazujący, ile z każdej raty trafia na kapitał, a ile na odsetki. Opcjonalna dodatkowa nadpłata miesięczna pokazuje, o ile wcześniej kredyt zostanie spłacony i ile odsetek dzięki temu zaoszczędzisz.',
        'steps' => [
            'Podaj cenę nieruchomości i wybierz walutę.',
            'Ustaw wkład własny, procentowo lub jako stałą kwotę.',
            'Podaj roczne oprocentowanie i wybierz okres kredytowania (10-30 lat albo wpisz własny okres).',
            'Opcjonalnie podaj dodatkową nadpłatę miesięczną, aby zobaczyć, o ile wcześniej kredyt zostanie spłacony.',
            'Sprawdź ratę miesięczną, odsetki i całkowity koszt, a następnie otwórz harmonogram spłat, aby zobaczyć podział rok po roku.',
        ],
        'features' => [
            'Rata miesięczna kapitału i odsetek, odsetki łączne i koszt całkowity',
            'Wkład własny procentowo lub jako stała kwota',
            'Pełny harmonogram spłat rok po roku',
            'Dodatkowe nadpłaty pokazują zaoszczędzony czas i odsetki',
            'Działa z dowolną walutą i okresem kredytowania od 1 do 50 lat',
            'Działa w całości w przeglądarce - nic, co wpiszesz, nigdzie nie jest wysyłane',
        ],
        'content' => [
            [
                'heading' => 'Jak obliczana jest rata miesięczna?',
                'body' => 'Kalkulator korzysta ze standardowego wzoru na ratę kredytu o stałym oprocentowaniu: M = P x r / (1 - (1 + r)^-n), gdzie P to kwota kredytu (cena nieruchomości minus wkład własny), r to miesięczne oprocentowanie (oprocentowanie roczne podzielone przez 12), a n to łączna liczba rat miesięcznych (okres kredytowania w latach razy 12). To ten sam wzór, którego banki używają przy kredycie o stałym oprocentowaniu, i obejmuje on wyłącznie kapitał i odsetki - podatek od nieruchomości, ubezpieczenie domu, ubezpieczenie kredytu (PMI) i czynsz wspólnoty nie są uwzględnione, ponieważ zależą od lokalizacji i kredytodawcy.',
            ],
            [
                'heading' => 'Dlaczego nadpłaty oszczędzają tak dużo odsetek?',
                'body' => 'Każda dodatkowa złotówka wpłacona na poczet kapitału przestaje generować odsetki przez resztę okresu kredytowania, więc nadpłacanie na początku kredytu - gdy saldo i odsetkowa część każdej raty są największe - ma największy wpływ. Kalkulator porównuje harmonogram z nadpłatą i bez niej, pokazując dokładnie, o ile miesięcy wcześniej kredyt zostanie spłacony i ile łącznych odsetek uda się uniknąć.',
            ],
            [
                'heading' => 'Czy wkład własny to w Wielkiej Brytanii "deposit"?',
                'body' => 'Kwota wpłacana z góry za nieruchomość, zmniejszająca potrzebny kredyt, w USA nazywana jest "down payment", a w Wielkiej Brytanii, Irlandii i kilku innych krajach - "deposit"; oba terminy oznaczają tu to samo co wkład własny. Wyższy wkład własny oznacza mniejszy kredyt, niższą ratę miesięczną i mniej odsetek zapłaconych łącznie, choć kredytodawcy mogą mieć też własny minimalny wkład własny i inne zasady przyznawania kredytu, których ten kalkulator nie uwzględnia.',
            ],
        ],
        'faqs' => [
            ['q' => 'Co obejmuje ta rata kredytu hipotecznego?', 'a' => 'Tylko kapitał i odsetki. Podatek od nieruchomości, ubezpieczenie domu, ubezpieczenie kredytu (PMI) i czynsz wspólnoty nie są uwzględnione, ponieważ zależą od lokalizacji, kredytodawcy i ubezpieczyciela.'],
            ['q' => 'Jak pomaga dodatkowa nadpłata miesięczna?', 'a' => 'Dodatkowe pieniądze trafiają bezpośrednio na kapitał kredytu, więc przestają generować odsetki przez resztę okresu kredytowania. Kalkulator pokazuje dokładnie, o ile miesięcy wcześniej kredyt zostanie spłacony i ile łącznych odsetek zaoszczędzisz.'],
            ['q' => 'Jaki jest typowy okres kredytowania?', 'a' => 'W USA najczęściej spotykane jest 30 lat; w Wielkiej Brytanii i Irlandii bardziej typowe jest 25 lat. Krótsze okresy (10-20 lat) oznaczają wyższą ratę miesięczną, ale znacznie mniej odsetek łącznie.'],
            ['q' => 'Czy wkład własny to to samo co "deposit"?', 'a' => 'Tak - "down payment" to amerykański termin, a "deposit" to termin używany w Wielkiej Brytanii i Irlandii na tę samą kwotę wpłacaną z góry za nieruchomość.'],
            ['q' => 'Dlaczego oferta mojego banku różni się od tego kalkulatora?', 'a' => 'Kredytodawcy doliczają podatek od nieruchomości, ubezpieczenie, PMI, opłaty i własne zaokrąglenia, a Twoje rzeczywiste oprocentowanie zależy od zdolności kredytowej, kredytodawcy i rodzaju kredytu. Ten kalkulator pokazuje podstawowe wyliczenia kapitału i odsetek, dzięki czemu możesz szybko porównać różne scenariusze.'],
        ],
        'table' => [
            'caption' => 'Rata miesięczna i łączne odsetki kredytu w wysokości $300,000 przy 6,5% w zależności od okresu (tylko kapitał i odsetki)',
            'headers' => ['Okres kredytowania', 'Rata miesięczna', 'Łączne zapłacone odsetki'],
            'rows' => [
                ['15 lat', '$2,613.32', '$170,397.98'],
                ['20 lat', '$2,236.72', '$236,812.66'],
                ['25 lat', '$2,025.62', '$307,686.45'],
                ['30 lat', '$1,896.20', '$382,633.47'],
            ],
        ],
    ],

    'loan-calculator' => [
        'name' => 'Kalkulator kredytu',
        'title' => 'Kalkulator Kredytu - Rata i Harmonogram Spłat',
        'description' => 'Darmowy kalkulator kredytu: podaj kwotę kredytu, oprocentowanie i okres, aby zobaczyć ratę miesięczną, łączne odsetki i harmonogram spłat rok po roku.',
        'h1' => 'Kalkulator kredytu',
        'tagline' => 'Sprawdź ratę miesięczną, łączne odsetki i harmonogram spłat rok po roku dla każdego kredytu o stałym oprocentowaniu.',
        'keywords' => [
            'kalkulator kredytu',
            'kalkulator raty kredytu',
            'kalkulator kredytu gotówkowego',
            'kalkulator kredytu samochodowego',
            'kalkulator harmonogramu spłat',
        ],
        'intro' => 'Kalkulator kredytu wylicza stałą ratę miesięczną kredytu na podstawie pożyczonej kwoty, oprocentowania i okresu kredytowania. Podaj swoje dane poniżej, aby zobaczyć ratę miesięczną, łączne odsetki zapłacone przez cały okres kredytu oraz pełny harmonogram spłat rok po roku, pokazujący, ile z każdej raty trafia na kapitał, a ile na odsetki. Działa dla kredytu gotówkowego, kredytu samochodowego, kredytu studenckiego i każdego innego kredytu o stałym oprocentowaniu i stałym okresie - opcjonalna dodatkowa nadpłata miesięczna pokazuje, o ile wcześniej zostanie spłacony i ile odsetek dzięki temu zaoszczędzisz.',
        'steps' => [
            'Podaj kwotę kredytu i wybierz walutę.',
            'Podaj roczne oprocentowanie i wybierz okres kredytowania (2-10 lat albo wpisz własny okres).',
            'Opcjonalnie podaj dodatkową nadpłatę miesięczną, aby zobaczyć, o ile wcześniej kredyt zostanie spłacony.',
            'Sprawdź ratę miesięczną, łączne odsetki i całkowitą spłatę, a następnie otwórz harmonogram spłat, aby zobaczyć podział rok po roku.',
        ],
        'features' => [
            'Rata miesięczna, odsetki łączne i całkowita spłata',
            'Działa dla kredytu gotówkowego, samochodowego, studenckiego i każdego innego kredytu o stałym oprocentowaniu',
            'Pełny harmonogram spłat rok po roku',
            'Dodatkowe nadpłaty pokazują zaoszczędzony czas i odsetki',
            'Działa z dowolną walutą i okresem od 1 do 50 lat',
            'Działa w całości w przeglądarce - nic, co wpiszesz, nigdzie nie jest wysyłane',
        ],
        'content' => [
            [
                'heading' => 'Jak obliczana jest rata miesięczna?',
                'body' => 'Kalkulator korzysta ze standardowego wzoru na ratę kredytu o stałym oprocentowaniu: M = P x r / (1 - (1 + r)^-n), gdzie P to kwota kredytu, r to miesięczne oprocentowanie (oprocentowanie roczne podzielone przez 12), a n to łączna liczba rat miesięcznych (okres kredytowania w latach razy 12). To ten sam wzór, którego kredytodawcy używają przy kredycie o stałym oprocentowaniu i stałym okresie - gotówkowym, samochodowym, studenckim lub innym - i obejmuje on wyłącznie kapitał i odsetki: opłaty kredytodawcy, koszty udzielenia kredytu czy ubezpieczenia nie są uwzględnione, ponieważ zależą od kredytodawcy i rodzaju kredytu.',
            ],
            [
                'heading' => 'Dlaczego nadpłaty oszczędzają tak dużo odsetek?',
                'body' => 'Każda dodatkowa złotówka wpłacona na poczet kapitału przestaje generować odsetki przez resztę okresu kredytowania, więc nadpłacanie na początku - gdy saldo i odsetkowa część każdej raty są największe - ma największy wpływ. Kalkulator porównuje harmonogram z nadpłatą i bez niej, pokazując dokładnie, o ile miesięcy wcześniej kredyt zostanie spłacony i ile łącznych odsetek uda się uniknąć. Sprawdź najpierw umowę kredytową: niektórzy kredytodawcy naliczają opłatę za wcześniejszą spłatę.',
            ],
        ],
        'faqs' => [
            ['q' => 'Co obejmuje ta rata kredytu?', 'a' => 'Tylko kapitał i odsetki. Opłaty kredytodawcy, koszty udzielenia kredytu i ubezpieczenia nie są uwzględnione, ponieważ zależą od kredytodawcy i rodzaju kredytu.'],
            ['q' => 'Czy mogę go użyć do kredytu samochodowego lub gotówkowego, nie tylko hipotecznego?', 'a' => 'Tak. Wyliczenia są takie same dla każdego kredytu o stałym oprocentowaniu i stałym okresie - gotówkowego, samochodowego, studenckiego lub innego. Do kredytu hipotecznego z wkładem własnym użyj Kalkulatora kredytu hipotecznego.'],
            ['q' => 'Jak pomaga dodatkowa nadpłata miesięczna?', 'a' => 'Dodatkowe pieniądze trafiają bezpośrednio na kapitał kredytu, więc przestają generować odsetki przez resztę okresu kredytowania. Kalkulator pokazuje dokładnie, o ile miesięcy wcześniej zostanie spłacony i ile łącznych odsetek zaoszczędzisz.'],
            ['q' => 'Dlaczego oferta mojego kredytodawcy różni się od tego kalkulatora?', 'a' => 'Kredytodawcy doliczają opłaty, ubezpieczenie i własne zaokrąglenia, a Twoje rzeczywiste oprocentowanie zależy od zdolności kredytowej, kredytodawcy i rodzaju kredytu. Ten kalkulator pokazuje podstawowe wyliczenia kapitału i odsetek, dzięki czemu możesz szybko porównać oferty.'],
            ['q' => 'Czy jest opłata za wcześniejszą spłatę kredytu?', 'a' => 'To zależy od kredytodawcy i umowy - niektóre kredyty o stałym oprocentowaniu przewidują opłatę za wcześniejszą spłatę. Sprawdź swoją umowę przed dokonaniem nadpłat.'],
        ],
        'table' => [
            'caption' => 'Rata miesięczna i łączne odsetki kredytu na 20 000 $ przy 7% w zależności od okresu (tylko kapitał i odsetki)',
            'headers' => ['Okres kredytowania', 'Rata miesięczna', 'Łączne odsetki'],
            'rows' => [
                ['2 lata', '$895.45', '$1,490.84'],
                ['3 lata', '$617.54', '$2,231.51'],
                ['5 lat', '$396.02', '$3,761.44'],
                ['7 lat', '$301.85', '$5,355.70'],
            ],
        ],
    ],

    'compound-interest-calculator' => [
        'name' => 'Kalkulator odsetek składanych',
        'title' => 'Kalkulator Odsetek Składanych - Wykres i Tabela',
        'description' => 'Darmowy kalkulator odsetek składanych. Sprawdź, jak kwota początkowa i wpłaty miesięczne rosną w czasie, z wykresem i tabelą rok po roku.',
        'h1' => 'Kalkulator odsetek składanych',
        'tagline' => 'Sprawdź, jak kwota początkowa i miesięczne wpłaty rosną w czasie, z wykresem i tabelą rok po roku.',
        'keywords' => [
            'kalkulator odsetek składanych',
            'kalkulator odsetek składanych z miesięcznymi wpłatami',
            'kalkulator wzrostu inwestycji',
            'kalkulator odsetek',
            'kalkulator dziennych odsetek składanych',
        ],
        'intro' => 'Odsetki składane to odsetki naliczane zarówno od Twoich pierwotnych pieniędzy, jak i od odsetek, które już wygenerowały, więc saldo rośnie szybciej, im dłużej pozostaje kapitalizowane. Podaj kwotę początkową, roczną stopę odsetek, liczbę lat wzrostu i częstotliwość kapitalizacji odsetek, a opcjonalnie dodaj miesięczną wpłatę. Kalkulator pokazuje saldo końcowe, łączną sumę wpłat, łączne zarobione odsetki, wykres wzrostu i tabelę rok po roku.',
        'steps' => [
            'Podaj kwotę początkową i wybierz walutę.',
            'Podaj roczną stopę odsetek, liczbę lat i częstotliwość kapitalizacji (rocznie, półrocznie, kwartalnie, miesięcznie lub dziennie).',
            'Opcjonalnie podaj miesięczną wpłatę, aby zobaczyć, jak regularne depozyty zwiększają wzrost.',
            'Sprawdź saldo końcowe, łączną sumę wpłat i łączne zarobione odsetki, a następnie otwórz tabelę rok po roku, aby zobaczyć pełny podział.',
        ],
        'features' => [
            'Saldo końcowe, łączna suma wpłat i łączne zarobione odsetki',
            'Wykres wzrostu pokazujący wpłaty w porównaniu z zarobionymi odsetkami',
            'Każda częstotliwość kapitalizacji: rocznie, półrocznie, kwartalnie, miesięcznie lub dziennie',
            'Opcjonalne miesięczne wpłaty oprócz kwoty początkowej',
            'Pełna tabela salda rok po roku',
            'Działa w całości w przeglądarce - nic, co wpiszesz, nigdzie nie jest wysyłane',
        ],
        'content' => [
            [
                'heading' => 'Jak obliczane są odsetki składane',
                'body' => 'Każdy raz, gdy odsetki są kapitalizowane, zostają dodane do salda, a kolejna runda odsetek jest naliczana od tej większej kwoty, nie tylko od pierwotnych pieniędzy. Im częściej odsetki są kapitalizowane (na przykład dziennie, a nie rocznie) i im dłużej pieniądze mogą rosnąć, tym większy jest efekt, ponieważ każdy okres kapitalizacji zawiera trochę więcej "odsetek od odsetek" niż poprzedni.',
            ],
            [
                'heading' => 'Dlaczego miesięczne wpłaty robią taką różnicę',
                'body' => 'Każda dodana wpłata zaczyna być kapitalizowana od dnia jej wpłacenia, więc pieniądze wpłacone na początku okresu mają znacznie więcej czasu na wzrost niż te wpłacone bliżej końca. Przez wiele lat regularne miesięczne wpłaty mogą dodać do salda końcowego więcej niż sama kwota początkowa.',
            ],
        ],
        'faqs' => [
            ['q' => 'Jaką częstotliwość kapitalizacji powinienem wybrać?', 'a' => 'Użyj tej, którą podaje Twój bank, obligacja lub konto inwestycyjne - konta oszczędnościowe są często kapitalizowane dziennie lub miesięcznie, a niektóre obligacje kapitalizują się półrocznie lub rocznie. Jeśli nie jesteś pewien, miesięczna jest typowym domyślnym wyborem, a różnica między częstotliwościami jest zwykle niewielka w porównaniu z samą stopą odsetek.'],
            ['q' => 'Czy to gwarantowany zwrot?', 'a' => 'Nie. Ten kalkulator prognozuje wzrost przy stałej stopie odsetek, którą wybierasz. Rzeczywiste zwroty z oszczędności i inwestycji zmieniają się z roku na rok, a inwestycje mogą tracić na wartości, więc traktuj wynik jako szacunek, a nie obietnicę.'],
            ['q' => 'Czy uwzględnia podatki lub inflację?', 'a' => 'Nie. Wynik to surowy wzrost Twoich pieniędzy przed opodatkowaniem odsetek lub zysków inwestycyjnych i bez korekty o inflację. Twoja rzeczywista siła nabywcza w przyszłości będzie niższa niż surowe saldo pokazane tutaj.'],
            ['q' => 'Jaka jest różnica między tym a Kalkulatorem kredytu?', 'a' => 'To narzędzie zwiększa saldo, w którym odsetki działają na Twoją korzyść (oszczędności i inwestycje). Kalkulator kredytu pokazuje saldo zmniejszające się w czasie, w którym odsetki działają na Twoją niekorzyść (kredyty i hipoteki).'],
            ['q' => 'Czy mogę go użyć do oszczędności na emeryturę?', 'a' => 'Tak, działa dla każdej jednorazowej kwoty wraz z regularnymi wpłatami - konta oszczędnościowego, konta inwestycyjnego lub konta emerytalnego. Po prostu użyj realistycznego szacowanego rocznego zwrotu i pamiętaj, że to prognoza, a nie gwarancja.'],
        ],
        'table' => [
            'caption' => 'Jak 10 000 $ rośnie przy 6% rocznych odsetek, kapitalizowanych miesięcznie, bez dalszych wpłat',
            'headers' => ['Lata', 'Saldo', 'Zarobione odsetki'],
            'rows' => [
                ['5 lat', '$13,488.50', '$3,488.50'],
                ['10 lat', '$18,193.97', '$8,193.97'],
                ['20 lat', '$33,102.04', '$23,102.04'],
                ['30 lat', '$60,225.75', '$50,225.75'],
            ],
        ],
    ],
];
