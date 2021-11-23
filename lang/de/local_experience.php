<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package    local_experience
 * @copyright  2020 Zentrum für Lernmanagement (www.lernmanagement.at)
 * @author    Robert Schrenk
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$string['pluginname'] = 'UI-Erfahrung';
$string['privacy:metadata'] = 'Dieses Plugin speichert keine personenbezogenen Daten';

$string['access_denied'] = 'Zugriff nicht gestattet!';
$string['advanced_options'] = 'Fortgeschrittenen-Modus';
$string['advanced_options:description'] = 'Im Fortgeschrittenen-Modus sehen Sie alle Funktionen der Seite!';
$string['attachlevelselectto'] = 'Level-Auswahl hinzufügen zu';
$string['attachlevelselectto:description'] = 'Geben Sie zeilenweise alle HTML-Container mit CSS-Regeln an, zu denen die Level-Auswahl hinzugefügt werden soll. Sie können mittels Parametern angeben, ob das Steuerelement an den Anfang oder das Ende eingefügt werden soll, bzw. ob ein Textlabel angezeigt wird.<br /><br /><i>CSS-Selektor|prepend oder append|true oder false';

$string['auto_set_completion_details'] = 'Setze Daten für Abschlussverfolgung';
$string['auto_set_completion_details:description'] = 'Wenn aktiviert, werden Regeln zur Abschlussverfolgung automatisch für neue Ressourcen/Aktivitäten und Dateiuploads gesetzt. Zusätzlich zu dieser Option müssen die konfigurierten Ziel-Tage über 0 sein!';
$string['auto_set_completion_add_days'] = 'Ziel-Tage in Formularen';
$string['auto_set_completion_add_days:description'] = 'Setze in Formularen das erwartete Abschlussdatum in x Tagen in der Zukunft. Es wird eine manuelle Abschlussverfolgung im Formular vorgeschlagen.';
$string['auto_set_completion_add_days_dnd'] = 'Ziel-Tage DND Uploads';
$string['auto_set_completion_add_days_dnd:description'] = 'Setze bei Drag&Drop Uploads das erwartete Abschlussdatum in x Tagen in der Zukunft. Es wird eine automatische Abschlussverfolgung eingestellt.';

$string['experience:cantrigger'] = 'Kann Erfahrungslevel wählen';

$string['injectquestion:stack:_ids'] = '0';
$string['injectquestion:stack:_fields'] = 'ans1type,ans1modelans,ans1mustverify,defaultmark,generalfeedbackeditable,name,penalty,prt1answertest_0,prt1feedbackvariables,prt1sans_0,prt1tans_0,prt1truefeedback_0editable,prt1answertest_1,prt1sans_1,prt1tans_1,prt1truefeedback_1editable,prt1falsefeedback_1editable,prt1truescore_1,prt1falsescore_1,questionnote,questionvariables,questiontexteditable,specificfeedbackeditable,variantsselectionseed';

$string['injectquestion:stack:0:ans1type'] = 'checkbox';
$string['injectquestion:stack:0:ans1modelans'] = 'ta';
$string['injectquestion:stack:0:ans1mustverify'] = '0';
$string['injectquestion:stack:0:defaultmark'] = '1';
$string['injectquestion:stack:0:generalfeedbackeditable'] = '';
$string['injectquestion:stack:0:name'] = 'Vorlage MC mit Feedback und Teilpunkten';

$string['injectquestion:stack:0:penalty'] = '0.1';
$string['injectquestion:stack:0:prt1feedbackvariables'] = '
    ans2: makelist(if member(i,ans1) then 1 else 0, i,1,5);
    tans2: makelist(if member(i,tans1) then 1 else 0, i,1,5);
    counter: 0; list2:[]; for i:1 step 1 thru 5 do if ans2[i]=tans2[i] then counter:counter+1 else (counter:counter,push(i,list2));
    list2:sort(list2);
';
$string['injectquestion:stack:0:prt1answertest_0'] = 'AlgEquiv';
$string['injectquestion:stack:0:prt1sans_0'] = 'ans1';
$string['injectquestion:stack:0:prt1tans_0'] = 'tans1';
$string['injectquestion:stack:0:prt1truefeedback_0editable'] = '
    <p>Aussage 1 {@ta[1][2]@}. {@fb[1]@} <br>
    Aussage 2 {@ta[2][2]@}. {@fb[2]@} <br>
    Aussage 3 {@ta[3][2]@}. {@fb[3]@} <br>
    Aussage 4 {@ta[4][2]@}. {@fb[4]@} <br>
    Aussage 5 {@ta[5][2]@}. <br> </p>
';
$string['injectquestion:stack:0:prt1answertest_1'] = 'AlgEquiv';
$string['injectquestion:stack:0:prt1sans_1'] = 'counter';
$string['injectquestion:stack:0:prt1tans_1'] = '4';
$string['injectquestion:stack:0:prt1truefeedback_1editable'] = '
    <p>Aussage 1 {@ta[1][2]@}. {@fb[1]@} <br>
    Aussage 2 {@ta[2][2]@}. {@fb[2]@} <br>
    Aussage 3 {@ta[3][2]@}. {@fb[3]@} <br>
    Aussage 4 {@ta[4][2]@}. {@fb[4]@} <br>
    Aussage 5 {@ta[5][2]@}.</p>
    <p style="text-align: left;">Es gibt nur einen Fehler bei Aussage {@list2[1]@}. <br> </p>
';
$string['injectquestion:stack:0:prt1falsefeedback_1editable'] = '
    <p style="text-align: left;">Aussage 1 {@ta[1][2]@}. {@fb[1]@} <br>
    Aussage 2 {@ta[2][2]@}. {@fb[2]@} <br>
    Aussage 3 {@ta[3][2]@}. {@fb[3]@} <br>
    Aussage 4 {@ta[4][2]@}. {@fb[4]@} <br>
    Aussage 5 {@ta[5][2]@}.</p>
    <p style="text-align: left;">Es gibt leider mehr als einen Fehler, insgesamt {@5-counter@} bei den Aussagen {@sort(list2)@}!! <br> </p>';
$string['injectquestion:stack:0:prt1truescore_1'] = '0.5';
$string['injectquestion:stack:0:prt1falsescore_1'] = '0';
$string['injectquestion:stack:0:questionnote'] = 'zufall';
$string['injectquestion:stack:0:questionvariables'] = '
    /*ai steht für ite Aussage, vi steht für iter Wahrheitswert, fbi steht für ites Feedback.
    Bei nur einer Aussage, braucht nur der zweite Eintrag in txti gelöscht werden, vi kann direkt auf true oder false gesetzt werden! */
    txt1: [ " Aussage 1A", " Aussage 1B"];
    n1: rand_with_step(1,length(txt1),1);
    a1: txt1[n1];
    v1: if n1=1 then true else false;
    fb1: "";

    txt2: [ " Aussage 2A", " Aussage 2B"];
    n2: rand_with_step(1,length(txt2),1);
    a2: txt2[n2];
    v2: if n2=1 then true else false;
    fb2: "";

    txt3: [ " Aussage 3A", " Aussage 3B"];
    n3: rand_with_step(1,length(txt3),1);
    a3: txt3[n3];
    v3: if n3=1 then true else false;
    fb3: "";


    txt4: [ " Aussage 4A", " Aussage 4B"];
    n4: rand_with_step(1,length(txt4),1);
    a4: txt4[n4];
    v4: if n4=1 then true else false;
    fb4: "";

    txt5: [ " Aussage 5A", " Aussage 5B"];
    n5: rand_with_step(1,length(txt5),1);
    a5: txt5[n5];
    v5: if n5=1 then true else false;
    fb5: "";


    txt6: [ " Aussage 6A", " Aussage 6B"];
    n6: rand_with_step(1,length(txt6),1);
    a6: txt6[n6];
    v6: if n6=1 then true else false;
    fb6: "";


    txt7: [ " Aussage 7A", " Aussage 7B"];
    n7: rand_with_step(1,length(txt7),1);
    a7: txt7[n7];
    v7: if n7=1 then true else false;
    fb7: "";

    txt8: [ " Aussage 8A", " Aussage 8B"];
    n8: rand_with_step(1,length(txt8),1);
    a8: txt8[n8];
    v8: if n8=1 then true else false;
    fb8: "";

    /*Liste müsste hier ergänzt oder gekürzt werden, wenn mehr oder weniger Aussagen da sind*/
    aussagen: [a1,a2,a3,a4,a5,a6,a7,a8];
    solutions: [v1,v2,v3,v4,v5,v6,v7,v8];
    feedback: [fb1,fb2,fb3,fb4,fb5,fb6,fb7,fb8];

    /*Auswahl der Fragen: ab hier ist nichts zu ändern!*/
    k1: rand_with_step(1, length(aussagen),1);
    k2: rand_with_prohib(1,length(aussagen),[k1]);
    k3: rand_with_prohib(1,length(aussagen),[k1,k2]);
    k4: rand_with_prohib(1,length(aussagen),[k1,k2,k3]);
    alt: if solutions[k1]=false and solutions[k2]=false and solutions[k3]=false and solutions[k4]=false then true else false;
    ta: [[1,solutions[k1],sconcat(" 1: ",aussagen[k1])],[2,solutions[k2],sconcat(" 2: ",aussagen[k2])],[3,solutions[k3],sconcat(" 3: ",aussagen[k3])],[4,solutions[k4],sconcat(" 4: ",aussagen[k4])],[5, alt," 5: Keine der obigen Aussagen ist richtig."]];
    fb: [feedback[k1],feedback[k2],feedback[k3],feedback[k4]]
    tans1: mcq_correct(ta);
';
$string['injectquestion:stack:0:questiontexteditable'] = '
    <p></p>
    <p>Wähle die richtigen Aussagen:</p>
    <p>[[input:ans1]] [[validation:ans1]]</p>
    <p>{@tans1@}</p>
    <p style="font-size:0.6em;text-align:right;">Erstellt von: (yourname)</p>
';
$string['injectquestion:stack:0:specificfeedbackeditable'] = '[[feedback:prt1]]';
$string['injectquestion:stack:0:variantsselectionseed'] = '';




$string['injecttext:page-question-type-multianswer'] = '
    <p>Ein Lückentext stellt einen Text in einem speziellen Moodle-Format zur Verfügung, in dem die Teilnehmer/innen verschiedene Fragen beantworten müssen. Die Fragen sind in den Text eingebaut und können vom Typ Multiple-Choice-Frage, Kurzantwort oder numerische Frage sein.</p>
    <p>Die Fragen müssen in einem speziellen Format (die Syntax wird weiter unten ausführlich beschrieben) eingeben: entweder direkt im Textfeld der Frage oder importiert aus einer vorab erstellten externen Text-Datei. </p>
    <p>Der folgende Text stellt eine einfache Lückentext-Frage dar:</p>
    <p style="margin-left: 40px;">
    Ordnen Sie die folgenden Städte den richtigen US-Bundesstaaten zu:<br />
    * San Francisco: {1:MULTICHOICE:=Kalifornien#OK~Arizona#Falsch}<br />
    * Tucson: {1:MULTICHOICE:Kalifornien#Falsch~%100%Arizona#OK}<br />
    * Los Angeles: {1:MULTICHOICE:=Kalifornien#OK~Arizona#Falsch}<br />
    * Phoenix: {1:MULTICHOICE:%0%Kalifornien#Falsch~=Arizona#OK}<br />
    Die Hauptstadt von Frankreich ist {1:SHORTANSWER:=Paris#Gratulation!~%50%Marseilles<br />
    #Nein, das ist die zweitgrößte Stadt Frankreichs (nach Paris).~*#Falsch. <br />
    Die Hauptstadt von Frankreich ist natürlich Paris!}.<br />
    </p>
    <a href="https://docs.moodle.org/38/de/Fragetyp_L%C3%BCckentext_(Cloze)" target="_blank">weiterführende Informationen</a>
    ';
$string['injecttext:page-question-type-ddwtos'] = '
    <p>In diesem Textbereich geben Sie den Fragetext als Lückentext ein. Die Lücken kennzeichnen Sie mit doppelten eckigen Klammern und einer fortlaufenden Nummer: [[1]], [[2]], [[3]].</p>
    <a href="https://docs.moodle.org/38/de/Fragetyp_Drag-and-Drop_auf_Text" target="_blank">weiterführende Informationen</a>
    ';
$string['injecttext:page-question-type-stack'] = '
    <p>Mehr Informationen über den STACK Fragetyp finden Sie in der <a href="https://docs.moodle.org/311/en/STACK_question_type" target="_blank">Moodle Dokumentation</a>.</p>
    <p>Wir haben für Sie zur Hilfestellung eine Vorlage für diesen Fragetyp vorbereitet. <a href="#" onclick="require([\'local_experience/main\'], function(M) { M.injectQuestionTemplate(\'stack\', 0) }); return false;" class="btn btn-secondary"><i class="fa fa-plus-circle"></i> Vorlage einfügen</a></p>
    ';
$string['injecttext:page-question-type-wordselect'] = '
    <p>Dieser Fragentyp wurde entwickelt, damit Lernende Text basierend auf bestimmten Kriterien auswählen können. Beispielsweise "Wähle das Verb im folgenden Satz". Vom Konzept her ist es ähnlich einer Multiple Choice Frage, wobei die Lernenden antworten, indem sie das richtige Wort auswählen. Dazu müssen die Lernenden einfach ein Wort anklicken.</p>
    <p>Es gibt ein Einführungsfeld für Erklärungen, in dem die Worte nicht auswählbar sind, und ein Fragentextfeld, in dem alle Wörter auswählbar sind. Wörter, die durch eckigen Klammern markiert sind, werden als korrekt gezählt.</p>
    <a href="https://docs.moodle.org/38/en/Wordselect_question_type" target="_blank">weiterführende Informationen</a>
    ';
$string['injecttext:page-mod-bigbluebuttonbn-mod'] = 'Das <a href="https://www.lernmanagement.at" target="_blank">Zentrum für Lernmanagement</a> stellt die Open Source Videokonferenzsoftware <a href="https://bigbluebutton.org" target="_blank">BigBlueButton</a> in einer Basis-Variante für bis zu 1000 gleichzeitige Nutzer/innen zur Verfügung. BBB-Tarife mit höherer bzw. garantierter Bandbreite können Sie kostenpflichtig bei diversen Anbietern in Anspruch nehmen.';
$string['injecttext:page-mod-bigbluebuttonbn-mod:readmore'] = '[<a href="{$a->wwwroot}/local/experience/pages/bigbluebutton.php" target="_blank">mehr erfahren</a>]';
$string['injecttext:page-mod-bigbluebuttonbn-mod:longtext'] = '<p>Um im Krisenfall rasch auf einen leistungsstärkeren, kostenpflichtigen BBB-Server wechseln zu können, haben wir 3 Anbieter exemplarisch zusammengetragen. Bei Auswahl eines externen Dienstleisters ist ein Vertrag zwischen Anbieter und Schule zu schließen. In Eduvidual kann über die Management Oberfläche ein alternativer BBB-Server für die eigene Schule eingetragen werden. Bei Fragen können Sie sich an <a href="mailto:rene.schwarzinger@lernmanagement.at?subject=BigBlueButton">rene.schwarzinger@lernmanagement.at</a> wenden!</p>

<p>Diese Angebote wurden im September 2020 als Beispiel zusammengetragen. Die jeweils aktuellen Preise und Konditionen erfragen Sie bitte bei den Anbietern direkt.</p>

<h4>meet-modular</h4>
<p>Mindestlaufzeit 3 Monate<br />
1 Klasse durchschnittlich a 25 Schüler nach fair use Prinzip<br />
Paket bis zu 12 Klassen: 149 € (pro Monat exkl. MwSt.)<br />
Paket bis zu 24 Klassen: 249 €<br />
Paket bis zu 60 Klassen: 349 €<br />
Serverstandort: Deutschland<br />
Kontakt: info@think-modular.com</p>

<h4>OpenFabNet</h4>
<p>Mindestlaufzeit 1 Monat<br />
Kosten: 1€ / pro Monat / gleichzeitigem User nach shared host Prinzip (keine MwSt.)<br />
Serverstandort: Österreich<br />
Kontakt: christian.schwarzinger@openfab.org</p>

<h4>Big Blue Meeting</h4>
<p>shared BBB hosting oder managed dedicated BBB hosting<br />
https://www.bigbluemeeting.com/</p>';

$string['pluginname:settings'] = 'UI-Erfahrung Einstellungen';
