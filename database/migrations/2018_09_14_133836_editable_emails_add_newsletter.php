<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditableEmailsAddNewsletter extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        \App\EditableEmail::addEmailsToDb();
        $data = [
            \App\EditableEmail::$MAIL_TEACHER_CONFIRMATION[0] => [
                'subject' => 'Confirmation enseignant',
                'text' => '<p>%PROF%,</p>
<p>Vous &ecirc;tes bien inscrits &agrave; la Mission Nichtrauchen 2018/2019.<br />Nous vous remercions de vous engager &agrave; nos c&ocirc;t&eacute;s pour un monde sans tabac.<br />Vous pourrez vous connecter &agrave; votre espace priv&eacute; sur le site www.missionnichtrauchen.lu, en cliquant sur le bouton &laquo;login&raquo;.&nbsp;<a href="%LIEN_LOGIN%">Connectez-vous</a><br />Vous pourrez y voir vos donn&eacute;es d&rsquo;inscription, les d&eacute;tails sur le d&eacute;roulement du concours.</p>
<p>Le concours d&eacute;bute le 6 novembre 2017 et se termine le 6 mai 2018. Fin octobre, vous allez recevoir votre dossier du concours par courrier.<br />Nous vous souhaitons &agrave; vous, ainsi qu&rsquo;&agrave; votre classe beaucoup de succ&egrave;s !</p>
<p>Bien cordialement,</p>
<p>L&rsquo;&eacute;quipe de la Fondation Cancer.</p>',
            ],
            \App\EditableEmail::$MAIL_NEWSLETTER_START[0] => [
                'subject' => 'Concours début',
                'text' => '<p>%PROF%,</p>
<p>Le concours Mission Nichtrauchen 2018/2019 commence aujourd&rsquo;hui, lundi 1 octobre.</p>
<p>Le dossier du concours incluant l&rsquo;affiche pour votre classe vous a &eacute;t&eacute; envoy&eacute; par courrier avant les vacances scolaires.<br />Pour traiter le sujet du tabagisme avec votre classe, vous pouvez utiliser nos fiches p&eacute;dagogiques en allemand et en fran&ccedil;ais et t&eacute;l&eacute;charger les solutions dans votre <a href="%LIEN_DOCUMENTS%">espace r&eacute;serv&eacute;</a>.</p>
<p><br />Un grand merci pour votre engagement &agrave; nos c&ocirc;t&eacute;s dans la pr&eacute;vention des cancers.<br />Nous vous souhaitons, &agrave; vous et &agrave; vos &eacute;l&egrave;ves, beaucoup de succ&egrave;s pour le concours !</p>
<p>Bien cordialement,</p>
<p>L&rsquo;&eacute;quipe de la Fondation Cancer.</p>',
            ],
            \App\EditableEmail::$MAIL_FOLLOW_UP[0] => [
                'subject' => 'Suivi',
                'text' => '<p>%PROF%,</p>
<p>Est-ce que votre classe&nbsp;%NOM_CLASSE% est toujours non-fumeur ?</p>
<p>- <a href="%SUIVI_OUI%">OUI</a><br />- <a href="%SUIVI_NON%">NON</a></p>
<p>Bien cordialement,<br />L&rsquo;&eacute;quipe de la Fondation Cancer.</p>
<p><br />Fondation Cancer</p>',
            ],
            \App\EditableEmail::$MAIL_FOLLOW_UP_YES[0] => [
                'subject' => 'Suivi réponse positive',
                'text' => '<p>%PROF%,</p>
<p>F&eacute;licitations, votre classe&nbsp;%NOM_CLASSE% est toujours non-fumeur et vous<br />continuez &agrave; participer au concours Mission Nichtrauchen.</p>
<p><br />Bien cordialement,<br />L&rsquo;&eacute;quipe de la Fondation Cancer.</p>
<p><br />Fondation Cancer</p>',
            ],
            \App\EditableEmail::$MAIL_FOLLOW_UP_NO[0] => [
                'subject' => 'Suivi réponse négative',
                'text' => '<p>%PROF%,</p>
<p>Malheureusement votre classe ne pourra donc plus participer au concours. C&rsquo;est<br />bien dommage !</p>
<p><br />Si vous d&eacute;sirez cependant aborder divers aspects du tabagisme (risques, co&ucirc;ts,<br />d&eacute;pendance, etc.) avec votre classe, vous pouvez utiliser nos fiches de travail.<br />Elles sont t&eacute;l&eacute;chargeables sur notre site (en fran&ccedil;ais et en allemand).<br />Si vous d&eacute;sirez les solutions, elles peuvent &ecirc;tre t&eacute;l&eacute;charg&eacute;es votre <a href="%LIEN_DOCUMENTS%">espace r&eacute;serv&eacute;</a>.<br />Merci encore pour votre engagement.</p>
<p><br />Avec nos meilleures salutations,<br />L&rsquo;&eacute;quipe de la Fondation Cancer.</p>
<p><br />Fondation Cancer</p>',
            ],
            \App\EditableEmail::$MAIL_FOLLOW_UP_3_YES_INVITE_PARTY[0] => [
                'subject' => 'Suivi invitation fête',
                'text' => '<p>%PROF%,</p>
<p>F&eacute;licitations, votre classe&nbsp;%NOM_CLASSE% a &eacute;t&eacute; non-fumeur &agrave; travers toute la<br />dur&eacute;e du concours Mission Nichtrauchen.<br />Nous vous invitons avec votre classe &agrave; la f&ecirc;te de cl&ocirc;ture du concours qui aura lieu<br />le mardi 6 juin &agrave; Luxembourg-Ville (Place d&rsquo;Armes) de 14 &agrave; 17 heures.<br />Pour participer &agrave; la f&ecirc;te de cl&ocirc;ture, <a href="%LIEN_FETE_INVITE%">inscrivez-vous ici</a>.</p>
<p>La date limite d&rsquo;inscription est le 19 mai.</p>
<p><br />Bien cordialement,<br />L&rsquo;&eacute;quipe de la Fondation Cancer.</p>
<p><br />Fondation Cancer</p>',
            ],
            \App\EditableEmail::$MAIL_PARTY_YES[0] => [
                'subject' => 'Confirmation participation fête',
                'text' => '<p>%PROF%,</p>
<p>Votre classe &laquo;%NOM_CLASSE%&raquo; est bien inscrite &agrave; la f&ecirc;te de cl&ocirc;ture.<br />Nous vous remercions de vous engager &agrave; nos c&ocirc;t&eacute;s pour un monde sans tabac.</p>
<p>Bien cordialement,<br />L&rsquo;&eacute;quipe de la Fondation Cancer.</p>
<p>Fondation Cancer</p>',
            ],
            \App\EditableEmail::$MAIL_FINAL[0] => [
                'subject' => 'Mail Final',
                'text' => '<p>Chers enseignants,</p>
<p>Merci &agrave; vous tous qui vous &ecirc;tes engag&eacute;s pour la pr&eacute;vention du tabagisme chez les<br />jeunes durant l&rsquo;ann&eacute;e scolaire 2018/2019 !</p>
<p>Nous esp&eacute;rons que vos &eacute;l&egrave;ves vont continuer &agrave; dire non au tabac et que vous<br />allez participer aux futures &eacute;ditions du concours Mission Nichtrauchen.<br />La f&ecirc;te de cl&ocirc;ture du 5 juin a &eacute;t&eacute; un grand succ&egrave;s avec plus de <strong>1100 participants</strong><br />pr&eacute;sents dans la bonne humeur.</p>
<p>les finalistes pr&eacute;sents &agrave; la f&ecirc;te de cl&ocirc;ture, les trois groupes qui ont gagn&eacute;<br />le rallye ont remport&eacute; un prix pour leur classe. Voici les classes gagnantes :</p>
<p>1er prix : 5CCL2 du Lyc&eacute;e Josy Barthel Mamer (enseignant : Mike DE VOS) ;<br />2e prix : 7G04 du Lyc&eacute;e Classique Diekirch (enseignant : Laurent HILGER) ;<br />3e prix : 6CLC1 du Lyc&eacute;e Robert Schumann (enseignante : Mich&egrave;le STEINES).</p>
<p>Un grand bravo aux heureux gagnants, &agrave; tous vos &eacute;l&egrave;ves... et &agrave; vous sans qui cette<br />action n&rsquo;aurait pas &eacute;t&eacute; possible !<br />Un certificat de r&eacute;ussite de la Mission Nichtrauchen sera envoy&eacute; par courrier &agrave;<br />toutes les classes finalistes.</p>
<p>les photos sont en ligne sur notre <a href="https://www.flickr.com/photos/fondationcancer/sets/72157667793781827/">galerie photo</a>.<br />En annexe, vous trouverez &eacute;galement les r&eacute;sultats du rallye ainsi que les solutions<br />des diff&eacute;rentes stations &laquo; quiz &raquo;.</p>
<p>Bien cordialement,<br />L&rsquo;&eacute;quipe de la Fondation Cancer.</p>',
            ],
            \App\EditableEmail::$MAIL_NEWSLETTER_ENCOURAGEMENT[0] => [
                'subject' => 'Newsletter encouragement',
                'text' => '',
            ],
        ];

        foreach ($data as $m => $mailData) {
            $email = \App\EditableEmail:: query()->where('key', $m)->first();
            if($email == null)
                continue;
            $email->update($mailData);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
    }
}
