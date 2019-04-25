<?php

use Illuminate\Database\Migrations\Migration;

class MigrateEmails extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        DB::table('editable_emails')
            ->whereIn('key', [
                'follow_up_1',
                'follow_up_2',
                'follow_up_3',
                'follow_up_1_reminder',
                'follow_up_2_reminder',
                'follow_up_3_reminder',
            ])
            ->update([
                'subject' => 'Statut de la classe − concours Mission Nichtrauchen',
                'text' => <<<END
<p>%PROF%,</p>
<p>Le concours Mission Nichtrauchen de la Fondation Cancer&nbsp;prend fin ce 5 mai.</p>
<p>Est-ce que votre classe&nbsp;<strong>%NOM_CLASSE%</strong>&nbsp;a r&eacute;ussi &agrave; rester une classe non-fumeur pendant toute la p&eacute;riode du concours&nbsp;? Cliquez sur la r&eacute;ponse correspondante.</p>
<p>- <a href="%SUIVI_OUI%">OUI</a><br />- <a href="%SUIVI_NON%">NON</a></p>
<p>Bien cordialement,</p>
<p>L&rsquo;&eacute;quipe de la Fondation Cancer.</p>
END
            ]);
        DB::table('editable_emails')
            ->whereIn('key', ['follow_up_1_no', 'follow_up_2_no', 'follow_up_3_no'])
            ->update([
                'text' => <<<END
<p>%PROF%,</p>
<p>Malheureusement votre classe&nbsp;<strong>%NOM_CLASSE%</strong> ne pourra donc plus participer au concours. C&rsquo;est bien dommage !</p>
<p>Si vous d&eacute;sirez cependant aborder divers aspects du tabagisme (risques, co&ucirc;ts, d&eacute;pendance, etc.) avec votre classe, vous pouvez utiliser nos fiches p&eacute;dagogiques.</p>
<p>Elles sont t&eacute;l&eacute;chargeables sur notre site (en fran&ccedil;ais et en allemand).<br />Si vous d&eacute;sirez consulter les solutions, elles peuvent &ecirc;tre t&eacute;l&eacute;charg&eacute;es sur votre <a href="%LIEN_DOCUMENTS%">espace r&eacute;serv&eacute;</a>.</p>
<p>Merci encore pour votre engagement. Avec nos meilleures salutations,</p>
<p>L&rsquo;&eacute;quipe de la Fondation Cancer.</p>
END
            ]);
        DB::table('editable_emails')
            ->whereIn('key', ['follow_up_1_yes', 'follow_up_2_yes'])
            ->update([
                'text' => <<<END
<p>%PROF%,</p>
<p>F&eacute;licitations, votre classe&nbsp;<strong>%NOM_CLASSE%</strong> est toujours non-fumeur et vous continuez &agrave; participer au concours <em>Mission Nichtrauchen</em>.</p>
<p>Le programme provisoire de le f&ecirc;te de cl&ocirc;ture qui aura lieu le 11 juin 2019 est t&eacute;l&eacute;chargeable dans votre espace priv&eacute;. Les inscriptions pour les classes non-fumeur d&eacute;buteront d&eacute;but mai.</p>
<p>Bien cordialement,</p>
<p>L&rsquo;&eacute;quipe de la Fondation Cancer.</p>
END
            ]);

        DB::table('editable_emails')
            ->whereIn('key', ['follow_up_yes_invite_party'])
            ->update([
                'subject' => 'Invitation à la fête de clôture pour les classes finalistes',
                'text' => <<<END
<p>%PROF%,</p>
<p>F&eacute;licitations, votre classe %NOM_CLASSE% a &eacute;t&eacute; non-fumeur pendant toute<br />la dur&eacute;e du concours Mission Nichtrauchen. Nous vous invitons avec votre classe<br />&agrave; la f&ecirc;te de cl&ocirc;ture du concours qui aura lieu le mardi 11 juin &agrave; Luxembourg-<br />Ville (Place d&rsquo;Armes) de 14h &agrave; 16h45. Le programme d&eacute;taill&eacute; et les informations<br />pratiques se trouvent dans votre espace priv&eacute;.</p>
<p>Est-ce que votre classe &laquo;%NOM_CLASSE%&raquo; participera &agrave; la f&ecirc;te de cl&ocirc;ture ?<br />Cliquez sur la r&eacute;ponse correspondante.<br />- <a href="%LIEN_FETE_OUI%">OUI</a><br />- <a href="%LIEN_FETE_NON%">NON</a></p>
<p>Si vous cliquez OUI, vous serez dirig&eacute;s vers votre espace priv&eacute; o&ugrave; vous &ecirc;tes<br />invit&eacute;s &agrave; communiquer les donn&eacute;es de votre classe et &agrave; valider l&rsquo;inscription.<br />Vous pouvez faire cette d&eacute;marche jusqu&rsquo;au 26 mai.</p>
<p>Bien cordialement,<br />L&rsquo;&eacute;quipe de la Fondation Cancer.</p>
END
            ]);

        DB::table('editable_emails')
            ->whereIn('key', ['party_confirmation_no'])
            ->update([
                'subject' => 'Participation à la fête de clôture',
                'text' => <<<END
<p>%PROF%,</p>
<p>Votre classe %NOM_CLASSE% ne participera pas à la f&ecirc;te de cl&ocirc;ture. Nous vous remercions pour votre engagement tout au long du concours et nous espérons pouvoir vous retrouver parmi les enseignants participants &agrave; l&rsquo;&eacute;dition 2019-2020.</p>
<p>Avec nos meilleures salutations,</p>
<p>L&rsquo;&eacute;quipe de la Fondation Cancer.</p>
END
            ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
    }
}
