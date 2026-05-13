<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employes', function (Blueprint $table) {
            $table->increments('id_employe');
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('telephone')->nullable()->unique();
            $table->string('departement');
            $table->date('date_embauche');
            $table->date('date_debauche')->nullable();
            $table->boolean('actif')->default(1);
        });

        Schema::table('utilisateurs', function (Blueprint $table) {
            $table->foreign('id_employe')->references('id_employe')->on('employes')->onDelete('set null');
        });

        Schema::create('fournisseurs', function (Blueprint $table) {
            $table->increments('id_fournisseur');
            $table->string('nom');
            $table->string('contact')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('adresse')->nullable();
            $table->string('site_web')->nullable();
            $table->timestamp('date_creation')->nullable();
            $table->timestamp('date_modification')->nullable();
        });

        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id_produit');
            $table->unsignedInteger('id_fournisseur')->nullable();
            $table->string('nom_produit');
            $table->text('description')->nullable();
            $table->integer('quantite')->default(0);
            $table->integer('seuil_alerte')->nullable();
            $table->decimal('prix_achat', 10, 2)->nullable();
            $table->decimal('prix_vente', 10, 2)->nullable();
            $table->timestamp('date_creation')->nullable();
            $table->timestamp('date_modification')->nullable();
            $table->foreign('id_fournisseur')->references('id_fournisseur')->on('fournisseurs')->onDelete('set null');
        });

        Schema::create('finances', function (Blueprint $table) {
            $table->increments('id_finance');
            $table->string('type_operation'); // revenu, dépense, facture
            $table->text('description')->nullable();
            $table->decimal('montant', 12, 2);
            $table->date('date_operation');
            $table->string('categorie')->nullable();
            $table->unsignedInteger('id_fournisseur')->nullable();
            $table->string('statut')->nullable();
            $table->string('reference_facture')->nullable();
            $table->timestamp('date_creation')->nullable();
            $table->foreign('id_fournisseur')->references('id_fournisseur')->on('fournisseurs')->onDelete('set null');
        });

        Schema::create('salaires', function (Blueprint $table) {
            $table->increments('id_salaire');
            $table->unsignedInteger('id_employe');
            $table->decimal('montant', 10, 2);
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->timestamp('date_creation')->nullable();
            $table->timestamp('date_modification')->nullable();
            $table->foreign('id_employe')->references('id_employe')->on('employes')->onDelete('cascade');
        });

        Schema::create('conges', function (Blueprint $table) {
            $table->increments('id_conge');
            $table->unsignedInteger('id_employe');
            $table->string('type_conge'); // RTT, CP, Maladie
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('statut')->default('En attente'); // En attente, Validé, Annulé
            $table->text('commentaires')->nullable();
            $table->foreign('id_employe')->references('id_employe')->on('employes')->onDelete('cascade');
        });

        Schema::create('absences', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('id_employe');
            $table->date('date_absence');
            $table->string('motif')->nullable();
            $table->timestamps();
            $table->foreign('id_employe')->references('id_employe')->on('employes')->onDelete('cascade');
        });

        Schema::create('livraisons', function (Blueprint $table) {
            $table->increments('id_livraison');
            $table->string('reference_commande', 100);
            $table->unsignedInteger('id_fournisseur')->nullable();
            $table->string('destinataire')->nullable();
            $table->string('statut_livraison', 50);
            $table->timestamp('date_creation')->nullable();
            $table->date('date_livraison')->nullable();
            $table->text('commentaires')->nullable();
            $table->foreign('id_fournisseur')->references('id_fournisseur')->on('fournisseurs')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('utilisateurs', function (Blueprint $table) {
            $table->dropForeign(['id_employe']);
        });

        Schema::dropIfExists('livraisons');
        Schema::dropIfExists('absences');
        Schema::dropIfExists('conges');
        Schema::dropIfExists('salaires');
        Schema::dropIfExists('finances');
        Schema::dropIfExists('stocks');
        Schema::dropIfExists('fournisseurs');
        Schema::dropIfExists('employes');
    }
};
