<?php

$GLOBALS['TL_LANG']['tl_job']['tstamp'] = array('Änderungsdatum', 'Datum und Uhrzeit der letzten Änderung');
$GLOBALS['TL_LANG']['tl_job']['title'] = array('Titel', 'Bitte geben Sie den Titel des Jobs ein.');
$GLOBALS['TL_LANG']['tl_job']['alias'] = array('Alias', 'Der Jobalias ist eine eindeutige Referenz, die anstelle der numerischen Job-ID aufgerufen werden kann.');
$GLOBALS['TL_LANG']['tl_job']['language'] = array('Sprache', 'Bitte wählen Sie die Sprache des Jobs aus.');
$GLOBALS['TL_LANG']['tl_job']['linkedJobs'] = array('Verlinkte Jobs', 'Bitte wählen Sie die verlinkten Jobs aus (andere Sprachen).');
$GLOBALS['TL_LANG']['tl_job']['employmentType'] = array('Anstellungsart', 'Bitte wählen Sie die Art des Anstellungsverhätnisses aus.');
$GLOBALS['TL_LANG']['tl_job']['employmentType']['options'] = array('FULL_TIME' => 'Vollzeit', 'PART_TIME' => 'Teilzeit', 'INTERN' => 'Praktikum', 'TEMPORARY' => 'Vorübergehend', 'CONTRACTOR' => 'Auftragsbasis', 'OTHER' => 'Andere');
$GLOBALS['TL_LANG']['tl_job']['location'] = array('Standort', 'Bitte wählen Sie den Standort des Jobs aus.');
$GLOBALS['TL_LANG']['tl_job']['salary'] = array('Gehalt', 'Bitte geben Sie den Gehalt des Jobs ein.');
$GLOBALS['TL_LANG']['tl_job']['salaryUnit'] = array('Gehalt Einheit', 'Jahr,Monat,Stündlich');
$GLOBALS['TL_LANG']['tl_job']['salaryUnit']['options'] = array(
    'MONTH' => 'Monatlich', 
    'HOUR' => 'Stündlich', 
    'DAY' => 'Tagesweise', 
    'WEEK' => 'Wöchentlich', 
    'YEAR' => 'Jährlich'
);


$GLOBALS['TL_LANG']['tl_job']['validThrough'] = array('Stellenausschreibungen Ablaufdatum', 'Beim entfernen eines Jobs muss das Ablaufdatum in der Vergangenheit liegen');

$GLOBALS['TL_LANG']['tl_job']['description'] = array('Beschreibung', 'Bitte wählen Sie die Beschreibung des Jobs ein.');

$GLOBALS['TL_LANG']['tl_job']['metaTitle'] = array('Metatitel', 'Bitte geben Sie den Metatitel des Jobs ein.');
$GLOBALS['TL_LANG']['tl_job']['metaDescription'] = array('Metabeschreibung', 'Bitte geben Sie die Metabeschreibung des Jobs ein.');

$GLOBALS['TL_LANG']['tl_job']['published'] = array('Job veröffentlichen', 'Den Job auf der Webseite anzeigen.');
$GLOBALS['TL_LANG']['tl_job']['featured'] = array('Job hervorheben', 'Den Job auf der Webseite hervorheben.');
$GLOBALS['TL_LANG']['tl_job']['start'] = array('Anzeigen ab', 'Wenn Sie der Job erst ab einem bestimmten Zeitpunkt auf der Webseite anzeigen möchten, können Sie diesen hier eingeben. Andernfalls lassen Sie das Feld leer.');
$GLOBALS['TL_LANG']['tl_job']['stop'] = array('Anzeigen bis', 'Wenn Sie der Job nur bis zu einem bestimmten Zeitpunkt auf der Webseite anzeigen möchten, können Sie diesen hier eingeben. Andernfalls lassen Sie das Feld leer.');

$GLOBALS['TL_LANG']['tl_job']['TEMPLATE']['more'] = 'Mehr Infos';
$GLOBALS['TL_LANG']['tl_job']['TEMPLATE']['selectAndContinue'] = 'Auswählen und weiter';
$GLOBALS['TL_LANG']['tl_job']['TEMPLATE']['applyNow'] = 'Jetzt bewerben';
$GLOBALS['TL_LANG']['tl_job']['TEMPLATE']['close'] = 'Schliessen';
$GLOBALS['TL_LANG']['tl_job']['TEMPLATE']['share'] = 'Teilen';
$GLOBALS['TL_LANG']['tl_job']['TEMPLATE']['print'] = 'Drucken';
$GLOBALS['TL_LANG']['tl_job']['TEMPLATE']['back'] = 'Zurück';

$GLOBALS['TL_LANG']['tl_job']['TEMPLATE']['online'] = 'Online bewerben';
$GLOBALS['TL_LANG']['tl_job']['TEMPLATE']['onlineText'] = 'Du bist von uns überzeugt? Gleich hier alle Daten eingeben und Bewerbung abschicken.';
$GLOBALS['TL_LANG']['tl_job']['TEMPLATE']['onlineLinkTitle'] = 'Jetzt bewerben';
$GLOBALS['TL_LANG']['tl_job']['TEMPLATE']['telephone'] = 'Rückruf anfordern';
$GLOBALS['TL_LANG']['tl_job']['TEMPLATE']['telephoneText'] = 'Du hast Fragen zur Anstellung, unserem Betrieb oder möchtest persönlich mit uns sprechen.';
$GLOBALS['TL_LANG']['tl_job']['TEMPLATE']['telephoneLinkTitle'] = 'Rückruf anfordern';
$GLOBALS['TL_LANG']['tl_job']['TEMPLATE']['meeting'] = 'Termin reservieren';
$GLOBALS['TL_LANG']['tl_job']['TEMPLATE']['meetingText'] = 'Komm auf einen Kaffee bei uns im Betrieb vorbei und wir besprechen alles vor Ort - Bewerbungsunterlagen bringst du am besten gleich mit.';
$GLOBALS['TL_LANG']['tl_job']['TEMPLATE']['meetingLinkTitle'] = 'Termin reservieren';

$GLOBALS['TL_LANG']['tl_job']['TEMPLATE']['toJobSite'] = 'Zur Jobseite';

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_job']['general_legend'] = 'Allgemeine Infos';
$GLOBALS['TL_LANG']['tl_job']['meta_legend'] = 'Metadaten';
$GLOBALS['TL_LANG']['tl_job']['information_legend'] = 'Jobeigenschaften';
$GLOBALS['TL_LANG']['tl_job']['image_legend'] = 'Bildeinstellungen';
$GLOBALS['TL_LANG']['tl_job']['publish_legend'] = 'Veröffentlichung';
$GLOBALS['TL_LANG']['tl_job']['expert_settings'] = 'Experteneinstellungen';
$GLOBALS['TL_LANG']['tl_job']['expertsettingsBaseSalary'] = array('BaseSalery Overwrite', 'Default = "@type": "MonetaryAmount","value": {"@type": "QuantitativeValue","value": SALERY,"unitText": "MONTH"},"currency" : "EUR"       -> see <a href="https://schema.org/baseSalary">schema.org/baseSalary</a>');
$GLOBALS['TL_LANG']['tl_job']['overwriteCurrency'] = array('Currency Overwrite', 'siehe <a href="https://en.wikipedia.org/wiki/ISO_4217" target="_blank">wiki/ISO_4217</a>');


