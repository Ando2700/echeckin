# Explication des tables : 
- **Gestion des lieux** (images, places)

  + <span style="color:#FFFF00">Images</span> : Permet de stocker les images associees a un lieu, qui donne une visuelle des emplacement des events
  + <span style="color:#FFFF00">Places</span> : Contient des lieux ou se deroulent les events, cette table est crucial pour attribuer un lieu a un event

- **Gestion des events**(events, event_types) 
    + <span style="color:#FFFF00">Eventtypes</span> : Permet de stocker les type d'event lie a la gestion des events
    + <span style="color:#FFFF00">Events</span> : Stocke tous les details de l'events, avec les dates debut et fin


- **Gestion des participants**(attendees)
    + Attendees : Contient les informations des participants, incluant leur : nom, prenom address, email. Cette table est utilisee pour attribuer de participants a l'event

- **Gestion des invitation**(invitations)
    + <span style="color:#FFFF00">Invitations</span> : Stocke les informations spe a chaque invitation, cette table facilite le suivi des invitations electroniques

- **Gestion des presences**(presences)
    + <span style="color:#FFFF00">Presences</span> : Permet d'enregistrer la presence des participants des evenements cette table est utile pour assurer la correlation entre les invitations et les participants
