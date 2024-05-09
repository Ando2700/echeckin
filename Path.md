# The Steps I followed : 
I. EVENTTYPE + LOGO
1. Create a event type : 
   - Example : Anniversaire, concert, ...
2. Modification event type
3. Create a logo : 
    - Echeck-in Event

II. PLACES
1. Create a place
2. Modification palce
3. Update
4. Delete

III. ATTENDEES 
1. CRUD 

IV. EVENTS
1. Creation d'evenement
2. Creation de view **v_event**(eventname, datedebut, datefin, description, nomplace, eventtype) (pas vraiment utile pour le moment)
3. List des events
4. Modification d'un evenement
5. Suppression
6. Ajout EVENTDETAILS (detail d'un evenement)

V. EVENTDETAILS
1. (Mbola vao migration sy ny vue an'ity no vita), a faire : creation de **table de liaison**

## DETAILS : 
+ Ajout de option [title] a chaque button ou de type **BTN** . 
+ ~~Adding : 127.0.0.1       Echeck-in-event.mah http://Echeck-in-event.mah:8000~~
+ URL Rewriting 
+ Font family pour Echeck-in Event au navbar : font-family: consolas
+ Font family pour body et le titre et sous-titre: Verdana, Geneva, sans-serif

### Controller + Class + Table + Migration
- EventTypeController | Eventtype | eventtypes
- ImageController - PlaceController
- > php artisan make:migration add_numberplace_to_places_table --table=places **Adding numberplace**
- > php artisan make:migration add_description_to_places_table --table=places **Adding description**
- > php artisan make:migration add_price_to_places_table --table=places **Adding price**
- > php artisan make:migration add_address_to_places_table --table=places **Adding address**


- _php artisan route:clear_ : Si route est introuvalble lors de php artisan route:list 

## PAGESS
- [x] Gestion de type d'evenement
  + [x] Search bar 
  + [x] CRUD Type evenement
  
- [x] Gestion des lieux
  + [x] Advanced Search bar
  + [x] CRUD Lieux

- [x] Gestion des participants (pour admin)
  - [x] Search bar and CRUD 