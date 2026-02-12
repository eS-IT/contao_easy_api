# [DEPRECATED] Contao_e@sy_API

## About

e@sy-API ist eine RESTfull-API für das Open Source CMS Contao. Die Schnittstelle bietet direkten Zugriff auf die Dantenbank einer Contao-Installation. Da die Datenquellen über eigene Klassen realisiert werden, ist es problemlos möglich auch andere Quellen hinzuzufügen, z.B. das Dateisystem. Die API liefert ein JSON-String mit dem Ergebniss der Anfrage oder einer Fehlermeldung zurück. Bei Fehlern wird auch ein entsprechender HTTP-Error-Code übermittlet. Die Daten befinden sich in der Regel im Feld "data" der zurück gelieferten Arrays. Als Ausgabeformat ist der Zeit nur JSON implementiert, es ist aber problemlos möglich z.B. XML einzubauen, da die Konvertierung in das Ausgabeformat durch Hooks geschieht.

Die API folgt den allgemeinen Maßgeaben für RESTfull-APIs, mit GET-Statements werden Daten abgerufen, mit DELETE gelöscht, mit POST erstellt und mit PUT aktualisiert. Da sich in Tests gezeigt hat, dass es mit der PUT-Methode zu Schwirigkeiten kommen kann, können Datensätze auch mit POST aktualisiert werden. Hier zu wird einfach die ID in den POST-Daten mit übergeben. Soll ein neuer Datensatz angeleget werden, wird die ID weggelassen.

## Sicherheit

Gesichert wird der Zugriff durch einen API-Key, außerdem werden bei Fehlerhaften Zugriffen die IP geloggt und nach drei Versuchen (Anzahl einstellbar) gespeert. Über den Key kann auch festgelegt werden, welche Methoden mit dem Key benutzt werden dürfen, so kann z.B. ein read-only-Key erzeugt werden, oder ein Key der nur Lesen und Aktulisieren, aber nicht Löschen oder Datensätze anlegen darf. Zusätzlich können die Tabellen festgelegt werden, auf die mit dem Key zugegriffen werden darf.

Es wird empfohlen die API über HTTPS zu nutzen, dies ist aber nicht zwingend.

## System requirements

 * Contao Open Souce CMS >= 3.1.0 stable


## Installation

 * Einfach die Erweiterung unter TL_ROOT/system/modules speichern
 * Einen Key anlegen


## Zugriff auf die API

Die URL für die Zugriff auf die API muss am Anfang folgende Standardparameter aufweisen:

*http(s)://example.org/api/1.0.0/db/...*

* Als erstes kommt natürlich die Adresse der Contao-Installation (*http(s)://example.org*).
* Danach "api", dadurch wird nicht die Seite geladen, sondern die Anfrage an die API weitergereicht (*/api*).
* Nun kommt der API-Level, so wird sichergestellt, das die Anfrage mit der verwendeten Version der API kompatibel ist (*/1.0.0*).
* Als letzter Standardparameter kommt die Quelle, in diesem Fall "db" für den Zugirff auf die Datenbank. Dies ist der Zeit die einzige Datenquelle, die implementiert ist (*/db*).

Die Anfrage bestehen immer aus Key-Value-Paaren und werden einfach an die URL angefügt, so wird für die Tabelleliste z.B. http://example.org/api/1.0.0/db/action/tablelist.html verwendet.
An jede Anfrage wird zusätzlich der Key mit ?key=47f9c... angehängt. *47f9c...* ist durch den erzeugten Key zu ersetzen. Eine vollständige URL sieht dann z.B. so aus:

http://example.org/api/1.0.0/db/action/tablelist.html?key=47f9c163985a224c8fe60cacddd8ad1828bb3f1df0c964db5a9b79fd18a01fbf2513572382c2aab844cccf1b9f3f2cef48cdc953f8c5a864d6bcb4bfe6aa61f8

Die meisten Abfragen beginnen mit dem Aufruf einer Aktion */action/* gefolgt von dem Namen der Aktion. Eine Auflistung der möglichen Aktionen ist den folgenden Beispielen zu entnehmen.

**Die Parameter werden vor der Verwendung mit urldecode() Dekodiert! Sie müssen beim Erstellen der URL entsprechend Kodiert werden!**

**Bei den folgenden Beispielen wird der übersichlichkeithalber der Anfang der URL, sowie der Key weggelassen!**

### Tabellenliste

**action/tablelist.html**

Hiermit wird eine Liste aller Tabellen ausgegeben, auf die mit dem verwendeten Key zugegriffen werden kann.

**Beispielergebniss:**

```
{"data":
    ["tl_article","tl_calendar","tl_calendar_events","tl_calendar_feed","tl_comments","tl_content", ...]
}
```

### Fieldlist

**/action/fieldlist/table/tl_user.html**

Gibt eine Liste der Felder der Tabelle, inkl. Informationen zu den Feldern zurück. So können z.B. automatisiert Formularfelder erstellt, oder Konvertierungen der Werte für die Anzeige vorgenommen werden.

**Beispielergebniss:**

```
{"data":
    {
        "0":{"name":"id","type":"int","length":"10","attributes":"unsigned","index":"PRIMARY", ...},
        "1":{"name":"tstamp","type":"int","length":"10","attributes":"unsigned","null":"NOT NULL","default":"0","extra":""},
        "2":{"name":"username","type":"varchar","length":"64","index":"UNIQUE","null":"NOT NULL","default":"","extra":""},
        ...
    }
}
```

### Ids einer Tabelle

**/action/idlist/table/tl_user.html**

Gibt eine Liste aller Ids einer Tabelle zurück.

**Beispielergebniss:**

```
{"data":
    ["1","7","6","2","3","5","4","8","9"]
}
```

### Datensatz einer Tabelle

**/action/details/table/tl_user/id/1.html**

Gibt einen Datensatz zurück.

**Beispielergebniss:**

```
{"data":
    {"id":"1","tstamp":"1378977133","username":"pfroch","name":"Patrick Froch", ...}
}
```

### Mehrere Datensätz laden

**/action/details/table/tl_member/city/Werne/login/1.html**

Natürlich können auch mehrere Datensätze geladen werden, in dem man die Filterkriterien in gleicher Weise angibt, wie im letzten Beispeil die Id. Die oben stehende Anfrage gibt alle Datensätze von den Personen zurück, die aus Werne kommen und sich am Frontend anmelden dürfen.

```
{"data":
    [
        "0":{"id":"1","tstamp":"1383835356","firstname":"Patrick","lastname":"Froch", ... },
        ...
    ]
}
```
