# Echeck-in event : 
0. [x] **Login and register page**

1. **Gestion des lieux** :
    + [x] Gestion d'image : CREATE TABLE image(id, path, place_id) : 
        - id
        - path
        - place_id
    + [x] Gestion des lieux : CREATE TABLE places(id, nomplace, description, numberplace) :  
        - id
        - place_name
        - description
        - numberplace
        - images
        - prix

2. [x] **Gestion des partipants** : CREATE TABLE attendees(id, firstname, lastname, email)
    - id
    - firstname
    - lastname
    - email

3. **Gestion des evenements** : 
    + [ ] evenenemt : CREATE TABLE event(id, event_name, date_debut, date_fin, description, lieu_id) : 
        - id
        - eventname
        - datedebut
        - datefin
        - description
        - place_id
        - eventtype_id
    + [x] type event : CREATE TABLE eventtypes(id, event_type)
        - id
        - eventtype    



4. [ ]**Gestion des invitations** : CREATE TABLE invitations(id, event_id, attendee_id, QR_code, status)
    - id
    - QR_code, 
    - status
    - event_id
    - attendee_id

5. [ ] **Gestion des presences** : CREATE TABLE presences(id, date_presence, heure_presence, invitation_id) 
    - id
    - date_presence
    - heure_presence
    - invitation_id


# CSS : 
~~Utilisation de DATATABLE : vendor~~