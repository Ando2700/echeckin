<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invitation Email</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .lead {
            font-size: 1.2em;
        }

        .event-name {
            font-size: 1.5em;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .alert {
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            border-radius: 4px;
            margin-top: 15px;
            padding: 15px;
        }

        .alert-info {
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }

        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <?php
    use Carbon\Carbon;
    ?>
    <div class="container">
        <p class="lead">Bonjour,</p>
        <p class="event-name">Vous êtes invités au : "{{ $event->eventname }}"!</p>
        <div class="alert alert-info">
            <p class="mb-0">Details:</p>
            <ul>
                <li>Nom de l'événement:<strong> {{ $event->eventname }}</strong> </strong></li>
                <li>Type d'événement :<strong> {{ $event->eventtype->eventtype }}</strong></li>
                <li>Au/à :<strong> {{ $event->place->nomplace }} - {{ $event->place->address }}</strong></li>
                <li>Date de début:<strong><span class="date">{{ Carbon::parse($event->datedebut)->locale('fr_FR')->isoFormat('LLLL') }}</span></strong></li>
                <li>Date de fin:<strong><span class="date">{{ Carbon::parse($event->datefin)->locale('fr_FR')->isoFormat('LLLL') }}</span></strong></li>
            </ul>
            <p>Description :{!! $event->description !!}</p>
        </div>

        <p class="lead">Voici votre QR code pour l'événement: <small>en pièce jointe</small></p>
        {{-- <p>Téléchargez ce fichier zip pour ouvrir votre QR Code(sur android) ou ouvrez simplement sur votre <strong>Google Drive</strong></p> --}}
        <p class="mt-3">Cordiallement!</p>
    </div>
</body>

</html>
