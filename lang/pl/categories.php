<?php

return [
    'text-tools' => [
        'name' => 'Narzędzia tekstowe',
        'short' => 'Tekst',
        'subtitle' => 'Licz i konwertuj swój tekst',
        'title' => 'Darmowe narzędzia tekstowe - licznik słów i wielkość liter',
        'description' => 'Darmowe narzędzia online do liczenia słów i znaków, zmiany wielkości liter i porządkowania tekstu. Natychmiastowe wyniki w przeglądarce, bez rejestracji.',
        'intro' => 'Licz słowa, sprawdź czas czytania i zmień wielkość liter w mgnieniu oka. Wszystko działa w Twojej przeglądarce, więc Twój tekst pozostaje prywatny.',
        'content' => [
            ['heading' => 'Z którego narzędzia tekstowego skorzystać?', 'body' => 'Użyj licznika słów, gdy musisz zmieścić się w limicie: wypracowania, listy motywacyjne, opisy produktów, posty w social media albo meta opisy SEO. Liczy słowa, znaki ze spacjami i bez, zdania i akapity oraz szacuje czas czytania i mówienia. Użyj konwertera wielkości liter, gdy słowa są dobre, ale wielkość liter nie: tekst napisany z włączonym Caps Lock, nagłówki wymagające wielkich liter czy nazwy zmiennych w camelCase lub snake_case.'],
            ['heading' => 'Czy te narzędzia tekstowe są prywatne?', 'body' => 'Obydwa działają całkowicie w Twojej przeglądarce. Wklejony tekst jest przetwarzany na Twoim urządzeniu i nigdy nie jest wysyłany na nasz serwer ani zapisywany, więc możesz bezpiecznie używać ich z wersjami roboczymi, e-mailami i dokumentami poufnymi. Po wczytaniu strony działają nawet bez połączenia z internetem.'],
        ],
        'faqs' => [
            ['q' => 'Jak policzyć słowa w dokumencie?', 'a' => 'Skopiuj tekst z Worda, Google Docs albo PDF-a i wklej go do licznika słów. Wyniki pojawiają się natychmiast, razem ze znakami, zdaniami, akapitami i czasem czytania.'],
            ['q' => 'Jak zmienić wielkie litery na małe?', 'a' => 'Wklej tekst do konwertera wielkości liter i wybierz małe litery. Możesz też wybrać wielkie litery w tytule, jak w zdaniu, camelCase, snake_case i inne, a potem skopiować wynik.'],
            ['q' => 'Czy te narzędzia tekstowe są płatne?', 'a' => 'Nie. Obydwa są darmowe, bez rejestracji, bez dziennego limitu i bez ograniczenia długości tekstu.'],
        ],
    ],
    'image-tools' => [
        'name' => 'Narzędzia do obrazów',
        'short' => 'Obraz',
        'subtitle' => 'Kompresuj, zmieniaj rozmiar i konwertuj',
        'title' => 'Darmowe narzędzia do obrazów - kompresja i konwersja',
        'description' => 'Kompresuj, zmieniaj rozmiar i konwertuj obrazy JPG, PNG i WebP bezpłatnie. Obrazy są przetwarzane w przeglądarce i nigdy nie są wysyłane na serwer.',
        'intro' => 'Zmniejsz rozmiar plików graficznych, dopasuj zdjęcia do dokładnych wymiarów i konwertuj między JPG, PNG i WebP. Twoje obrazy nigdy nie opuszczają Twojego urządzenia.',
        'content' => [
            ['heading' => 'Skompresować obraz czy zmienić jego rozmiar?', 'body' => 'Kompresuj, gdy obraz wygląda dobrze, ale plik jest zbyt duży, na przykład aby zmieścić się w limicie przesyłania, takim jak 100 KB, albo aby strona ładowała się szybciej: kompresor obrazów zachowuje wymiary i zmniejsza rozmiar pliku. Zmieniaj rozmiar, gdy wymiary są nieprawidłowe, na przykład zdjęcie o szerokości 4000 pikseli, które musi mieć 1080 pikseli szerokości do social media. Zmniejszenie dużego zdjęcia także znacznie zmniejsza rozmiar pliku.'],
            ['heading' => 'JPG, PNG czy WebP: który format jest najlepszy?', 'body' => 'JPG jest najlepszy do zdjęć, PNG do logo, zrzutów ekranu i wszystkiego, co wymaga przezroczystości, a WebP do stron internetowych, bo daje najmniejsze pliki w obu przypadkach. Według Google bezstratne obrazy WebP są o około 26% mniejsze niż PNG, a stratne obrazy WebP o 25-34% mniejsze niż porównywalne JPEG.'],
        ],
        'faqs' => [
            ['q' => 'Jak zmniejszyć obraz do 100 KB?', 'a' => 'Otwórz kompresor obrazów, wybierz „Rozmiar docelowy” i wpisz 100. Narzędzie znajduje najlepszą jakość, która zmieści się w limicie, i zmniejsza wymiary tylko, jeśli to konieczne.'],
            ['q' => 'Czy mogę tutaj przekonwertować PNG na JPG albo WebP na PNG?', 'a' => 'Tak. Narzędzie do zmiany rozmiaru i konwersji obrazów przełącza między JPG, PNG i WebP, z lub bez zmiany rozmiaru. Przezroczyste obszary staną się białe po zapisaniu jako JPG.'],
            ['q' => 'Czy moje zdjęcia są wysyłane na serwer?', 'a' => 'Nie. Obrazy są przetwarzane w Twojej przeglądarce za pomocą Canvas API i nigdy nie opuszczają Twojego urządzenia.'],
        ],
    ],
    'pdf-tools' => [
        'name' => 'Narzędzia PDF',
        'short' => 'PDF',
        'subtitle' => 'Łącz, konwertuj, kompresuj i chroń pliki PDF',
        'title' => 'Darmowe narzędzia PDF - łączenie, konwersja, edycja',
        'description' => 'Łącz, dziel, konwertuj, kompresuj i chroń pliki PDF online za darmo. Bez wysyłania plików, bez znaków wodnych, bez rejestracji - wszystko w przeglądarce.',
        'intro' => 'Pełny zestaw narzędzi PDF, który nigdy nie wysyła Twoich plików: łącz albo dziel dokumenty, obracaj, zmieniaj kolejność i usuwaj strony, zmieniaj PDF-y w JPG, PNG, Worda albo Excela (i odwrotnie), konwertuj HTML albo zwykły tekst do PDF, zmniejszaj duże pliki oraz dodawaj albo usuwaj hasło otwierania. Każde narzędzie przetwarza Twój dokument na Twoim własnym urządzeniu, bez znaku wodnego, bez limitu stron i bez sztucznych ograniczeń rozmiaru.',
        'content' => [
            ['heading' => 'Którego narzędzia PDF potrzebuję?', 'body' => 'Użyj „Połącz PDF”, aby zebrać kilka plików w jeden dokument w wybranej kolejności, na przykład CV, list motywacyjny i certyfikaty do podania o pracę, oraz „Podziel PDF”, aby zrobić odwrotnie: wyodrębnić strony do nowego pliku, podzielić dokument na zakresy albo zapisać każdą stronę jako osobny PDF. „Obróć PDF” naprawia przekrzywione strony, „Usuń strony PDF” usuwa niepotrzebne, a „Organizuj PDF” zmienia kolejność całego dokumentu przez przeciąganie miniatur stron. „Kompresuj PDF” zmniejsza plik za duży do wysłania e-mailem, a „Zabezpiecz PDF” / „Odblokuj PDF” dodają albo usuwają hasło otwierania.'],
            ['heading' => 'Konwersja PDF na inne formaty i z powrotem', 'body' => '„PDF do Worda” i „PDF do Excela” wyodrębniają tekst (a w Excelu także wiersze i kolumny) z PDF-a do edytowalnego pliku .docx albo .xlsx, a „Word do PDF” i „Excel do PDF” robią odwrotnie: zamieniają dokument Word albo arkusz kalkulacyjny w stały PDF, który wygląda tak samo wszędzie. „PDF do JPG” i „PDF do PNG” zapisują strony jako obrazy, a „HTML do PDF” zamienia wklejony HTML albo zwykły tekst w PDF do pobrania. Te konwersje są orientacyjne: tekst i podstawowa struktura są dobrze zachowywane, ale dokładny układ, tabele, wykresy i czcionki nie zawsze są zachowywane - strona każdego narzędzia wyjaśnia, czego się spodziewać.'],
            ['heading' => 'Czy edytowanie PDF online jest bezpieczne?', 'body' => 'Na większości witryn z PDF Twój dokument jest wysyłany na serwer, zanim coś z nim się stanie. Tutaj każde narzędzie działa w Twojej przeglądarce za pomocą JavaScript, więc umowy, wyciągi bankowe, dokumenty Word i arkusze kalkulacyjne nigdy nie opuszczają Twojego urządzenia, a wyniki nie mają znaku wodnego ani limitu stron.'],
        ],
        'faqs' => [
            ['q' => 'Jak połączyć pliki PDF w jeden?', 'a' => 'Otwórz „Połącz PDF”, dodaj dwa lub więcej plików, ustaw je w odpowiedniej kolejności strzałkami i kliknij „Połącz PDF”. Połączony plik od razu się pobiera.'],
            ['q' => 'Jak wyodrębnić strony z PDF?', 'a' => 'Otwórz „Podziel PDF”, wybierz „Wyodrębnij strony”, wpisz potrzebne strony, na przykład 1-3, 5, i kliknij „Podziel PDF”.'],
            ['q' => 'Czy mogę przekonwertować PDF na edytowalny plik Word albo Excel?', 'a' => 'Tak: „PDF do Worda” i „PDF do Excela” wyodrębniają tekst (a w Excelu także wiersze i kolumny) w sposób orientacyjny. Złożone układy, tabele, kolumny i obrazy nie zawsze są zachowywane, co wyjaśnia strona każdego narzędzia.'],
            ['q' => 'Czy mogę połączyć pliki PDF chronione hasłem?', 'a' => 'Nie bezpośrednio. Otwórz plik przy użyciu hasła, zapisz lub wydrukuj niechronioną kopię, a potem połącz tę kopię. Możesz też najpierw użyć „Odblokuj PDF”, jeśli znasz hasło.'],
            ['q' => 'Czy moje pliki są wysyłane na serwer?', 'a' => 'Nie. Wszystkie narzędzia PDF na tej stronie przetwarzają Twoje pliki lokalnie w przeglądarce za pomocą JavaScript, więc nigdy nie są wysyłane ani przechowywane.'],
        ],
    ],
    'calculators' => [
        'name' => 'Kalkulatory',
        'short' => 'Kalkulatory',
        'subtitle' => 'Rozwiązuj codzienne obliczenia',
        'title' => 'Darmowe kalkulatory online - wiek i procenty',
        'description' => 'Darmowe kalkulatory online do wieku, procentów, zmiany procentowej i więcej. Dokładne, natychmiastowe wyniki z pokazanym wzorem dla każdego rezultatu.',
        'intro' => 'Szybkie i dokładne kalkulatory do codziennych obliczeń: dokładny wiek, procenty, wzrosty i spadki.',
        'content' => [
            ['heading' => 'Co mogą obliczyć te kalkulatory?', 'body' => 'Kalkulator wieku podaje dokładny wiek w latach, miesiącach i dniach na podstawie daty urodzenia, dzień tygodnia urodzenia i odliczanie do następnych urodzin, a także uwzględnia lata przestępne. Kalkulator procentów obejmuje najczęstsze pytania w jednym miejscu: X% z Y, jaki procent Y stanowi X, procentowy wzrost lub spadek między dwiema liczbami oraz dodawanie lub odejmowanie procentu, np. rabatu albo podatku.'],
            ['heading' => 'Jak sprawdzić wynik?', 'body' => 'Każdy wynik pokazuje użyty wzór, dzięki czemu możesz śledzić obliczenia w zadaniach domowych, rabatach, podwyżkach czy raportach. Na przykład zmiana procentowa z 80 do 100 to (100 - 80) / 80 x 100 = 25%.'],
        ],
        'faqs' => [
            ['q' => 'Jak dokładnie liczony jest wiek?', 'a' => 'Najpierw liczone są pełne lata, potem pełne miesiące, a na końcu pozostałe dni. Jest to ta sama metoda, która jest używana w dokumentach urzędowych.'],
            ['q' => 'Jak obliczyć wzrost procentowy?', 'a' => 'Odejmij starą wartość od nowej, podziel przez starą wartość i pomnóż przez 100. Kalkulator procentów robi to za Ciebie i pokazuje wzór.'],
            ['q' => 'Czy kalkulatory są darmowe?', 'a' => 'Tak. Są darmowe, nie wymagają rejestracji i działają w Twojej przeglądarce, więc nic, co wpiszesz, nie jest zapisywane.'],
        ],
    ],
    'generators' => [
        'name' => 'Generatory',
        'short' => 'Generatory',
        'subtitle' => 'Kody QR i hasła',
        'title' => 'Darmowe generatory - kody QR i generator haseł',
        'description' => 'Generuj kody QR do linków i Wi-Fi oraz silne, losowe hasła za darmo. Bez rejestracji, bez śledzenia i bez zapisywania tego, co utworzysz.',
        'intro' => 'Twórz kody QR do linków, Wi-Fi i kontaktów oraz generuj silne, losowe hasła tworzone na Twoim urządzeniu.',
        'content' => [
            ['heading' => 'Kody QR i hasła, tworzone na Twoim urządzeniu', 'body' => 'Generator kodów QR twórzy kody do linków, tekstu, sieci Wi-Fi, e-maili, numerów telefonów i SMS-ów, w wybranych przez Ciebie kolorach i rozmiarach, jako PNG do ekranów albo SVG do druku. Generator haseł tworzy losowe hasła o długości od 4 do 128 znaków za pomocą kryptograficznie bezpiecznego generatora liczb losowych Twojej przeglądarki.'],
            ['heading' => 'Czemu te kody i hasła nie wygasają?', 'body' => 'Kody QR są statyczne: Twoje dane są zapisane w samym kodzie, a nie za linkiem przekierowującym, dlatego działają na zawsze i nie zależą od tej witryny. Hasła są tworzone na Twoim urządzeniu i nigdzie nie są wysyłane, więc nie istnieje żadna ich kopia na serwerze.'],
        ],
        'faqs' => [
            ['q' => 'Jak zrobić kod QR do Wi-Fi?', 'a' => 'Wybierz „Wi-Fi” w generatorze kodów QR, wpisz nazwę sieci, hasło i typ zabezpieczeń, a potem pobierz kod. Goście skanują go i łączą się bez wpisywania hasła.'],
            ['q' => 'Jak długie powinno być hasło?', 'a' => 'Co najmniej 15 znaków, czyli minimum w aktualnych wytycznych NIST, a 16 lub więcej w przypadku ważnych kont.'],
            ['q' => 'Czy mogę używać kodów QR komercyjnie?', 'a' => 'Tak. Utworzone kody możesz bezpłatnie wykorzystywać na opakowaniach, w menu, na ulotkach i wizytówkach.'],
        ],
    ],
    'games' => [
        'name' => 'Losowanie i gry',
        'short' => 'Gry',
        'subtitle' => 'Kości, monety i koła',
        'title' => 'Rzut kością, moneta i koło - darmowe narzędzia losowe',
        'description' => 'Darmowy rzut kością online, rzut monetą, losujące koło i generator liczb losowych. Sprawiedliwe, naprawdę losowe wyniki z zabawnymi animacjami. Bez rejestracji.',
        'intro' => 'Rzuć kością, podrzuć monetę, zakręć kołem albo wylosuj liczby. Każdy wynik jest generowany sprawiedliwie na Twoim urządzeniu za pomocą bezpiecznej losowości.',
        'content' => [
            ['heading' => 'Z którego narzędzia losowego skorzystać?', 'body' => 'Użyj rzutu kością do gier planszowych i rozgrywek RPG (od D4 do D100, do 10 kości na raz). Podrzuć monetę do szybkiej decyzji tak albo nie, albo aby wybrać, kto zaczyna. Zakręć kołem, aby wylosować imię lub opcję z listy do 100 pozycji, i użyj generatora liczb losowych do loterii, losowań i próbkowania, z powtórzeniami lub bez.'],
            ['heading' => 'Czy wyniki są naprawdę losowe?', 'body' => 'Każde narzędzie korzysta z wbudowanego w przeglądarkę Web Crypto API, kryptograficznie bezpiecznego źródła losowości, dlatego każdy wynik jest równie prawdopodobny i nie można go przewidzieć. Wynik jest ustalany przed rozpoczęciem animacji, więc animacja nie może na niego wpłynąć.'],
        ],
        'faqs' => [
            ['q' => 'Jak wylosować losowe imię z listy?', 'a' => 'Wklej imiona do losującego koła, jedno w wierszu, i naciśnij Zakręć. Zaznacz „Usuń zwycięzcę po każdej turze”, aby wylosować kilka imion bez powtórzeń.'],
            ['q' => 'Jak wygenerować liczby lotto?', 'a' => 'Użyj generatora liczb losowych z szablonem „Lotto 6 z 49” albo ustaw własny zakres i liczbę z zaznaczonym „Bez duplikatów”.'],
            ['q' => 'Czy rzut monetą online jest sprawiedliwy?', 'a' => 'Tak. Każdy rzut ma dokładnie 50% szans na orła i 50% na reszkę, generowane za pomocą bezpiecznej losowości.'],
        ],
    ],
    'time-tools' => [
        'name' => 'Narzędzia czasu',
        'short' => 'Czas',
        'subtitle' => 'Minutniki, stoper i sen',
        'title' => 'Darmowe narzędzia czasu - stoper i minutnik',
        'description' => 'Precyzyjny stoper online z czasami okrążeń i minutnik z alarmem i szablonami. Darmowe, bez rejestracji i dokładne nawet w tle karty.',
        'intro' => 'Precyzyjny stoper z okrążeniami i minutnik z alarmem. Obydwa zachowują dokładny czas, nawet gdy karta jest w tle.',
        'content' => [
            ['heading' => 'Stoper, minutnik czy kalkulator snu?', 'body' => 'Użyj stopera, aby zmierzyć, jak długo coś trwa, z okrążeniami i czasami etapowymi do 1/100 sekundy. Użyj minutnika, gdy wiesz, ile czasu masz, na przykład przy gotowaniu, nauce czy 25-minutowym Pomodoro, i chcesz alarmu na koniec. Użyj kalkulatora snu, aby zaplanować porę snu albo pobudki według 90-minutowych cykli snu, albo policzyć, ile godzin spałeś.'],
            ['heading' => 'Czy pozostają dokładne w karcie w tle?', 'body' => 'Tak. Przeglądarki zwalniają strony w kartach w tle, dlatego te narzędzia liczą czas od ustalonego momentu startu lub końca za pomocą zegara wysokiej rozdzielczości Twojego urządzenia, a nie poprzez liczenie ticków. Odczyt jest prawidłowy, gdy wrócisz do karty, a minutnik pokazuje też pozostały czas w tytule karty.'],
        ],
        'faqs' => [
            ['q' => 'Czy minutnik może działać, gdy korzystam z innych kart?', 'a' => 'Tak. Zostaw kartę otwartą: czas pozostaje dokładny, a alarm włączy się, gdy odliczanie się zakończy.'],
            ['q' => 'Czy mogę zapisywać czasy okrążeń?', 'a' => 'Tak. Naciśnij Okrążenie (albo L) w stoperze. Każde okrążenie pokazuje swój czas i czas całkowity, a wszystkie możesz skopiować na raz.'],
            ['q' => 'Ile godzin snu potrzebują dorośli?', 'a' => 'National Sleep Foundation zaleca dorosłym w wieku 18-64 lat od 7 do 9 godzin snu na noc.'],
        ],
    ],
    'developer-tools' => [
        'name' => 'Narzędzia dla programistów',
        'short' => 'Dev',
        'subtitle' => 'Formatuj, koduj i sprawdzaj',
        'title' => 'Darmowe narzędzia dla programistów - JSON, Base64 i IP',
        'description' => 'Darmowe narzędzia online dla programistów: formatuj i waliduj JSON, koduj i dekoduj tekst i pliki Base64 oraz sprawdź swój publiczny adres IP natychmiast.',
        'intro' => 'Codzienne narzędzia dla programistów i osób związanych z IT: formatuj JSON, koduj Base64 i sprawdzaj swój adres IP.',
        'content' => [
            ['heading' => 'Codzienne narzędzia dla programistów', 'body' => 'Formatter JSON upiększa, waliduje i minifikuje JSON oraz wskazuje dokładny wiersz i kolumnę każdego błędu. Koder i dekoder Base64 konwertuje tekst lub pliki do i z Base64, w tym wariant bezpieczny dla URL i data URL do HTML i CSS. „Jaki jest mój adres IP” pokazuje Twój publiczny adres IP, czy jest to IPv4 czy IPv6, oraz szczegóły o Twojej przeglądarce i urządzeniu.'],
            ['heading' => 'Czy bezpiecznie jest wklejać tutaj dane API?', 'body' => 'Tak. Narzędzia JSON i Base64 działają całkowicie w Twojej przeglądarce, więc odpowiedzi API, tokeny i pliki konfiguracyjne nigdy nie są wysyłane na serwer. Jedynym zapytaniem, jakie wykonuje witryna, jest to potrzebne narzędziu „Jaki jest mój adres IP” do odczytania Twojego publicznego adresu, który jest Ci wyświetlany, a nie zapisywany.'],
        ],
        'faqs' => [
            ['q' => 'Czemu mój JSON jest nieprawidłowy?', 'a' => 'Najczęstsze przyczyny to nadmiarowe przecinki, pojedyncze cudzysłowy zamiast podwójnych, klucze bez cudzysłowów i komentarze. Standardowy JSON nie dopuszcza żadnego z nich.'],
            ['q' => 'Czy Base64 to szyfrowanie?', 'a' => 'Nie. Base64 to kodowanie, które każdy może odwrócić, więc nigdy nie używaj go do ochrony haseł lub tajnych danych.'],
            ['q' => 'Jaka jest różnica między IPv4 i IPv6?', 'a' => 'Adresy IPv4 wyglądają jak 203.0.113.42 i w większości regionów się już wyczerpały. Adresy IPv6, takie jak 2001:db8::1, zostały wprowadzone, aby zapewnić znacznie więcej adresów.'],
        ],
    ],
];
