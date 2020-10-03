# Timber Reception App

O aplicatie de generare NIR-uri pentru societatile care prelucreaza/comercializeaza cheresteaua.
Ofera export de date in diverse formate populare (excel, pdf, etc) si optiunea de calcul automat al cantitatii de ambalaj importate in Romania.

Aplicatia permite utilizarea pentru mai multe societati/puncte de lucru, fiecare dintre ele fiind separate unele de altele, datele despre o anumite societate/punct de lucru fiind vizibile doar pentru cei care au drepturi pentru aceasta.
In dashboard-ul fiecarei societati exista un grafic cu livrarile de la furnizorii externi (furnizorii care nu sunt punct de lucru sau filiala a companiei) pe anul curent si pretul mediu calculat (in momentul de fata se afiseaza ca moneda euro) pentru luna anterioara si cea curenta.

### TO BE DONE:
- modul gestionare gestionare comenzi

## Cerinte server/software
Pentru a putea rula aplicatia, cerintele minime sunt urmatoarele:

    - server VPS cu minim 1GB RAM si 1 procesor
    - sistemul de operare preferat este Ubuntu 18.04.3 LTS
    - Nginx
    - MySQL
    - PHP 7.2 cu toate extensiile necesare Laravel instalate
    - Composer
    - Node js
    - Git

## Instalare aplicatie
1. Cloneaza repo github
2. Ruleaza in ssh in directorul unde este clonata aplicatia codul
    ```
    composer install --optimize-autoloader --no-dev
    ```
3. Copiaza fisierul .env.example si redenumeste-l in .env
4. Genereaza cheia aplicatiei cu 
    ```
    ~php artisan key:generate
    ```
5. Completeaza datele pentru seed-ul primului utilizator si companii (toate datele de dupa egal trebuie sa fie intre ghilimele)
6. Creaza baza de date MySQL cu numele dorit
7. Completeaza numele bazei de date, utilizatorul si parola in .env
8. Ruleaza comanda 
    ```
    php artisan migrate --seed
    ```
9. Pentru a da posibilitatea utilizatorului sa incarce o poza de profil trebuie sa rulati comanda `php artisan storage:link` si sa setati
CHOWN si CHMOD corect pentru `calea_catre_folder_unde_a_fost_clonat_repo_github/timber_reception/storage/app/public`

***NOTA***

Pentru a putea accesa aplicatia va trebui sa configurati Nginx sa ia datele din folderul `calea_catre_folder_unde_a_fost_clonat_repo_github/timber_reception/public/`.
Tutoriale in diverse formate se pot gasi pe google cu un simplu search cu `install nginx on ubuntu 18.04`.

## Accesare aplicatie
Accesarea aplicatiei se face urmand adresa setata in momentul in care ati configurat VPS.
Pentru a va autentifica trebuie sa folositi user-ul si parola setata in fisierul .env.
Configurati aplicatia si introduceti toate datele necesare in nomenclator.

***Spor la completat date!***

***Aplicatia este oferita sub licenta MIT***

***Detalii si contact in comentariile de la acest repo pe GitHub***


