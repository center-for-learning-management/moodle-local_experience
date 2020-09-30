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

$string['experience:cantrigger'] = 'Kann Erfahrungslevel wählen';

$string['injecttext:page-question-type-multianswer'] = '<p>Ein Lückentext stellt einen Text in einem speziellen Moodle-Format zur Verfügung, in dem die Teilnehmer/innen verschiedene Fragen beantworten müssen. Die Fragen sind in den Text eingebaut und können vom Typ Multiple-Choice-Frage, Kurzantwort oder numerische Frage sein.</p>
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
<a href="https://docs.moodle.org/38/de/Fragetyp_L%C3%BCckentext_(Cloze)" target="_blank">weiterführende Informationen</a>';
$string['injecttext:page-question-type-ddwtos'] = '<p>In diesem Textbereich geben Sie den Fragetext als Lückentext ein. Die Lücken kennzeichnen Sie mit doppelten eckigen Klammern und einer fortlaufenden Nummer: [[1]], [[2]], [[3]].</p>
<a href="https://docs.moodle.org/38/de/Fragetyp_Drag-and-Drop_auf_Text" target="_blank">weiterführende Informationen</a>';
$string['injecttext:page-question-type-wordselect'] = '<p>Dieser Fragentyp wurde entwickelt, damit Lernende Text basierend auf bestimmten Kriterien auswählen können. Beispielsweise "Wähle das Verb im folgenden Satz". Vom Konzept her ist es ähnlich einer Multiple Choice Frage, wobei die Lernenden antworten, indem sie das richtige Wort auswählen. Dazu müssen die Lernenden einfach ein Wort anklicken.</p>
<p>Es gibt ein Einführungsfeld für Erklärungen, in dem die Worte nicht auswählbar sind, und ein Fragentextfeld, in dem alle Wörter auswählbar sind. Wörter, die durch eckigen Klammern markiert sind, werden als korrekt gezählt.</p>
<a href="https://docs.moodle.org/38/en/Wordselect_question_type" target="_blank">weiterführende Informationen</a>';
$string['injecttext:page-mod-bigbluebuttonbn-mod'] = 'Das <a href="https://www.lernmanagement.at" target="_blank">Zentrum für Lernmanagement</a> stellt die Open Source Videokonferenzsoftware <a href="https://bigbluebutton.org" target="_blank">BigBlueButton</a> in einer Basis-Variante für bis zu 1000 gleichzeitige Nutzer/innen zur Verfügung. BBB-Tarife mit höherer bzw. garantierter Bandbreite können Sie kostenpflichtig bei diversen Anbietern in Anspruch nehmen.';
$string['injecttext:page-mod-bigbluebuttonbn-mod:readmore'] = '[<a href="{$a->wwwroot}/local/experience/pages/bigbluebutton.php" target="_blank">mehr erfahren</a>]';
$string['injecttext:page-mod-bigbluebuttonbn-mod:longtext'] = '<p>Um im Krisenfall rasch auf einen leistungsstärkeren, kostenpflichtigen BBB-Server wechseln zu können, haben wir 3 Anbieter exemplarisch zusammengetragen. Bei Auswahl eines externen Dienstleisters ist ein Vertrag zwischen Anbieter und Schule zu schließen. In Eduvidual kann über die Management Oberfläche ein alternativer BBB-Server eingetragen werden. Bei Fragen können Sie sich an <a href="mailto:rene.schwarzinger@lernmanagement.at?subject=BigBlueButton">rene.schwarzinger@lernmanagement.at</a> wenden!</p>

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
