@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <h1 class="text-center mb-5">Politique de Confidentialité</h1>
            
            <div class="card shadow-sm">
                <div class="card-body">
                    <h2 class="h4 mb-3">1. Introduction</h2>
                    <p>EazyStore s'engage à protéger la vie privée de ses utilisateurs. Cette politique de confidentialité décrit comment nous collectons, utilisons et protégeons vos informations personnelles lorsque vous utilisez notre site web.</p>
                    
                    <h2 class="h4 mb-3 mt-4">2. Informations collectées</h2>
                    <p>Nous collectons les informations suivantes :</p>
                    <ul>
                        <li><strong>Informations d'identification :</strong> nom, prénom, adresse email</li>
                        <li><strong>Informations de livraison :</strong> adresse de livraison, numéro de téléphone</li>
                        <li><strong>Informations de commande :</strong> historique des achats, préférences</li>
                        <li><strong>Informations techniques :</strong> adresse IP, type de navigateur, pages visitées</li>
                    </ul>
                    
                    <h2 class="h4 mb-3 mt-4">3. Utilisation des informations</h2>
                    <p>Nous utilisons vos informations personnelles pour :</p>
                    <ul>
                        <li>Traiter et livrer vos commandes</li>
                        <li>Vous envoyer des confirmations et mises à jour</li>
                        <li>Améliorer nos services et l'expérience utilisateur</li>
                        <li>Répondre à vos demandes et questions</li>
                        <li>Respecter nos obligations légales</li>
                    </ul>
                    
                    <h2 class="h4 mb-3 mt-4">4. Partage des informations</h2>
                    <p>Nous ne vendons, n'échangeons ni ne louons vos informations personnelles à des tiers, sauf dans les cas suivants :</p>
                    <ul>
                        <li>Avec votre consentement explicite</li>
                        <li>Pour respecter une obligation légale</li>
                        <li>Avec nos prestataires de services (transport, paiement) dans le cadre de votre commande</li>
                    </ul>
                    
                    <h2 class="h4 mb-3 mt-4">5. Sécurité des données</h2>
                    <p>Nous mettons en œuvre des mesures de sécurité appropriées pour protéger vos informations personnelles :</p>
                    <ul>
                        <li>Chiffrement des données sensibles</li>
                        <li>Accès restreint aux informations personnelles</li>
                        <li>Surveillance régulière de nos systèmes</li>
                        <li>Formation de notre personnel à la protection des données</li>
                    </ul>
                    
                    <h2 class="h4 mb-3 mt-4">6. Cookies</h2>
                    <p>Notre site utilise des cookies pour améliorer votre expérience :</p>
                    <ul>
                        <li><strong>Cookies essentiels :</strong> nécessaires au fonctionnement du site</li>
                        <li><strong>Cookies de performance :</strong> pour analyser l'utilisation du site</li>
                        <li><strong>Cookies de fonctionnalité :</strong> pour mémoriser vos préférences</li>
                    </ul>
                    <p>Vous pouvez configurer votre navigateur pour refuser les cookies, mais cela peut affecter certaines fonctionnalités du site.</p>
                    
                    <h2 class="h4 mb-3 mt-4">7. Vos droits</h2>
                    <p>Conformément à la loi sénégalaise, vous disposez des droits suivants :</p>
                    <ul>
                        <li><strong>Droit d'accès :</strong> connaître les données que nous détenons sur vous</li>
                        <li><strong>Droit de rectification :</strong> corriger des informations inexactes</li>
                        <li><strong>Droit de suppression :</strong> demander la suppression de vos données</li>
                        <li><strong>Droit d'opposition :</strong> vous opposer au traitement de vos données</li>
                        <li><strong>Droit à la portabilité :</strong> récupérer vos données dans un format structuré</li>
                    </ul>
                    
                    <h2 class="h4 mb-3 mt-4">8. Conservation des données</h2>
                    <p>Nous conservons vos informations personnelles aussi longtemps que nécessaire pour :</p>
                    <ul>
                        <li>Fournir nos services</li>
                        <li>Respecter nos obligations légales</li>
                        <li>Résoudre les litiges</li>
                        <li>Faire respecter nos accords</li>
                    </ul>
                    
                    <h2 class="h4 mb-3 mt-4">9. Transferts internationaux</h2>
                    <p>Vos informations personnelles sont traitées au Sénégal. Si des transferts vers d'autres pays sont nécessaires, nous nous assurons que des garanties appropriées sont en place.</p>
                    
                    <h2 class="h4 mb-3 mt-4">10. Modifications de cette politique</h2>
                    <p>Nous pouvons mettre à jour cette politique de confidentialité de temps à autre. Les modifications seront publiées sur cette page avec une date de mise à jour révisée.</p>
                    
                    <h2 class="h4 mb-3 mt-4">11. Contact</h2>
                    <p>Pour toute question concernant cette politique de confidentialité ou pour exercer vos droits, contactez-nous :</p>
                    <ul>
                        <li><strong>Email :</strong> gnaweparfait1@gmail.com</li>
                        <li><strong>Téléphone :</strong> +221 76 676 25 42</li>
                        <li><strong>Adresse :</strong> EazyStore, Rue de Almadies, Dakar, Sénégal</li>
                    </ul>
                    
                    <div class="alert alert-info mt-4">
                        <strong>Dernière mise à jour :</strong> {{ date('d/m/Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 