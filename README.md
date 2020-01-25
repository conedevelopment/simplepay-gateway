# Olvass el

Ez a bővítmény OTP SimplePay fizetési kaput biztosít WooCommerce (WordPress) áruházak részére.

## A bővítmény telepítése

[A bővítmény letöltése](https://github.com/thepinecode/simplepay-gateway/archive/master.zip) után ugyan úgy telepíthető mint bármely WordPress bővítmény.

### Verziók

| Bővítmény | SimplePay API |
|:---------:|:-------------:|
| v1+       | v1            |
| v2+       | v2            |

### Frissítések

Telepítés után a bővítmény automatikusan ellenőrzni a frissítéseket, amelyek ugyan úgy telepíthetők mint bármely WordPress bővítmény.

## Beállítások

A teszt és az éles adatok a SimplePay adminisztrációs felületén érhetők el. Az érvényes szerződés megkötését követően, a SimplePay hozzáférést biztosít a felületekhez.

### Teszt beállítások

A teszt adatok elérhetők a [https://sandbox.simplepay.hu/admin/login](https://sandbox.simplepay.hu/admin/login) linken.

#### Kereskedői fiókok

A SimplePay adminisztrációs felületén elérhető a kereskedői azonosító (`MERCHANT`) és a titkosító kulcs (`SECRET_KEY`). Ezeket az adatokat kell megadni a WooCommerce (WordPress) felületén a fizetési beállításoknál, a SimplePay fül alatt.

> Több kereskedői fiók esetén, a megvelelő devizanemet figyelembevéve kell az adatokat megadni.

#### IPN/IRN URL

Az áruház és a SimplePay kommunikációját a megfelelő URL beállítással biztosíthatjuk a SimplePay adminisztrációs felületén. Az URL automatikusan generálásra kerül a WooCommerce (WordPress) fizetési beállításoknál, a SimplePay fül alatt.

> Ügyeljünk, hogy a kimásolt adatok pontosak legyenek, ne tartalmazzanak extra szóközöket.

### Éles beállítások

Az éles beállítások azt követően lesznek elérhetőek, hogy a SimplePay munkatársai ellenőrízték az integrációt tesztüzemben és megfelelőnek a működését. Az éles adatok beállítása teljesen ugyan az mint a teszt adatoké, de a [https://admin.simplepay.hu/admin/login](https://admin.simplepay.hu/admin/login) linken érhetők el.

## Visszatérítések

Visszatérítés a WooCommerce (WordPress) és az OTP SimplePay oldaláról is kezdeményezhető.

> Győződjünk meg, hogy az IPN/IRN URL megfelelően van beállítva.

## Korlátozások

### Támogatott devizák

Jelenleg (a SimplePay által) támogatott devizák: `HUF`, `EUR` és `USD`.

### Adók

A WooCommerce (WordPress) máshogy kezeli az adókat mint a SimplePay. A lehetséges áreltérések megelőzése érdekében, a **bruttó** árak kerülnek átadása, de a feltüntetett adó mértéke `0`.

### Kedvezmények

A WooCommerce (WordPress) máshogy kezeli a kedvezményeket mint a SimplePay. A lehetséges áreltérések megelőzése érdekében, a kedvezményes árak kerülnek átadása, de a feltüntetett kedvezmény mértéke `0`.

### Ismétlődő fizetések

Jelenleg nem támogatjuk az ismétlődő fizetéseket.

> Miért? Mert az tranzakciók indítása és kezelése az áruházat terhelik. Ennek biztonságos kivitelezése sok áruház esetében nem garantált.
