@extends('other.layouts.app')
@section('content')
<?php
use Carbon\carbon;
?>
    <h2>Facture № {{ $factures->id }}</h2>
    <form action="{{ route('savedetailfacture') }}" method="POST" enctype="multipart/form-data">
        {{-- <form action="{{ route('savedetailfacture') }}" method="POST" enctype="multipart/form-data"> --}}
        @csrf
        {{-- Natao hidden loa teto --}}
        <div class="form-group">
            <label for="nom" hidden>Facture</label>
            <select class="form-select" hidden name="id" id="id" aria-label="nom">
                <option value="{{ $factures->id }}">{{ $factures->id }}</option>
            </select>
            @error('id')
                <div class="alert alert-danger mt-2">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="nom">Acte</label>
            <select class="form-select" name="type_acte" id="type_acte" aria-label="type_acte">
                @foreach ($actes as $acte)
                    <option value="{{ $acte->type_acte }}">{{ $acte->type_acte }}</option>
                @endforeach
            </select>
            @error('type_acte')
                <div class="alert alert-danger mt-2">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="montant">Montant</label>
            <input type="number" class="form-control @error('montant') is-invalid @enderror" name="montant"
                value="{{ old('montant') }}" placeholder="">
            @error('montant')
                <div class="alert alert-danger mt-2">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <input type="submit" class="btn btn-primary" value="Valider">
        <button type="reset" class="btn btn-md btn-warning">Reset</button>

    </form>
    <br/>
    <button class="btn btn-outline-primary" onclick="exportToPDF()">Exporter PDF</button>
    <div id="invoice">
        <h3>Detail facture de :{{ $factures->patient->nom }}</h3>
                    <p>Facture du : <strong>{{ Carbon::parse($factures->date_facture)->format('d F Y') }}</strong></p>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Acte</th>
                    <th scope="col">Montant</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($detailfacture_patient as $detail)
                    <tr>
                        <td>{{ $detail->type_acte }}</td>
                        <td>{{ $detail->montant }} Ar</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
        <p>Total :
            {{-- @foreach ($montant as $montant)
                {{ $montant->montant_total }}
            @endforeach --}}
            @forelse ($montant as $montant)
                <strong>{{ $montant->montant_total }} Ar</strong>
            @empty
                Aucune facture .
            @endforelse
        </p>
    </div>
    <script type="text/javascript" src="{{ asset('js/jspdf.debug.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/html2canvas.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/html2pdf.min.js')}} "></script>
    
    <script>
        function exportToPDF() {
          // Récupérer le contenu de la balise <div id="invoice">
          const invoice = document.getElementById('invoice');
          
          // Créer un nouvel objet jsPDF
          const doc = new jsPDF();
      
          // Générer le PDF à partir du contenu de la balise <div>
          doc.fromHTML(invoice, 15, 15, {
            'width': 170
          });
      
          // Enregistrer le PDF
          doc.save('export.pdf');
        }
      </script>

@endsection
