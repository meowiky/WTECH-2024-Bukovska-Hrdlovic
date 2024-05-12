# Semestrálny projekt - elektronický obchod

### Vypracové Viktóriou Bukovskou a Jakubom Hrdlovičom

### Github repo: https://github.com/meowiky/WTECH-2024-Bukovska-Hrdlovic

## Zadanie:

Vytvorte webovú aplikáciu - eshop, ktorá komplexne rieši nižšie definované prípady použitia vo vami zvolenej doméne (napr. elektro, oblečenie, obuv, nábytok).

### Aplikácia - eshop

**Aplikácia musí realizovať tieto prípady použitia:**

**Klientská časť**
* zobrazenie prehľadu všetkých produktov z vybratej kategórie používateľom
    * základné filtrovanie (aspoň podľa 3 atribútov, napr. rozsah cena od-do, značka, farba)
    * stránkovanie
    * preusporiadanie produktov (napr. podľa ceny vzostupne/zostupne)
* zobrazenie konkrétneho produktu - detail produktu
    * pridanie produktu do košíka (ľubovolné množstvo)
* plnotextové vyhľadávanie nad katalógom produktov
* zobrazenie nákupného košíka
    * zmena množstva pre daný produkt
    * odobratie produktu
    * výber dopravy
    * výber platby
    * zadanie dodacích údajov
    * dokončenie objednávky
    * umožnenie nákupu bez prihlásenia
    * prenositeľnosť nákupného košíka v prípade prihláseného používateľa
* registrácia používateľa/zákazníka
* prihlásenie používateľa/zákazníka
* odhlásenie zákazníka

**Administrátorská časť**
* prihlásenie administrátora do administrátorského rozhrania eshopu
* odhlásenie administrátora z administrátorského rozhrania
* vytvorenie nového produktu administrátorom cez administrátorské rozhranie
    * produkt musí obsahovať minimálne názov, opis, aspoň 2 fotografie
* upravenie/vymazanie existujúceho produktu administrátorom cez administrátorské rozhranie