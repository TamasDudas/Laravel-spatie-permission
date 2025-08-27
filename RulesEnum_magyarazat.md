# RulesEnum.php Magyarázat

## Mi ez a fájl?

Ez egy **PHP 8.1+ enum** (felsorolás típus), ami felhasználói szerepköröket/jogosultságokat definiál a Laravel alkalmazásban. Ez a `RulesEnum.php` fájl egy modern Laravel fejlesztési gyakorlatot reprezentál a szerepkörök/jogosultságok kezelésére.

## Fájl helye

```
app/Enum/RulesEnum.php
```

## Kód struktúra

### 1. Enum definíció

```php
enum RulesEnum: string
```

- Ez egy **backed enum** (string típussal támogatott)
- Minden enum értéknek van egy string reprezentációja az adatbázisban

### 2. Enum esetek (cases)

```php
case Admin = 'admin';
case Commenter = 'commenter';
case User = 'user';
```

- **3 felhasználói szerepkör** van definiálva
- A bal oldal (`Admin`) a PHP kódban használt konstans
- A jobb oldal (`'admin'`) az adatbázisban tárolt érték

### 3. Instance `label()` metódus

```php
public function label()
{
    return match($this) {
        self::Admin => 'Admin',
        self::Commenter => 'Commenter',
        self::User => 'User',
    };
}
```

- Egy konkrét enum instance-hoz tartozó címke visszaadása
- **Match expression** (PHP 8.0+) használata
- **Ez az egyetlen metódus ami kell** - nincs szükség külön `labels()` metódusra

## Miért csak ez az egy metódus elég?

**Konkrét címke lekérése:**

```php
$role = RulesEnum::Admin;
echo $role->label(); // 'Admin'
```

**Összes címke dropdown-hoz (ha kell):**

```php
$options = collect(RulesEnum::cases())
    ->mapWithKeys(fn($case) => [$case->value => $case->label()])
    ->toArray();
// Eredmény: ['admin' => 'Admin', 'commenter' => 'Commenter', 'user' => 'User']
```

## Használati példák

### Alapvető használat

```php
// Enum érték létrehozása
$role = RulesEnum::Admin;

// Adatbázis érték lekérése
echo $role->value; // 'admin'

// Emberi olvasható címke
echo $role->label(); // 'Admin'
```

### Dropdown/Select mezőkhöz

```php
// Összes lehetőség dropdown-hoz
$options = collect(RulesEnum::cases())
    ->mapWithKeys(fn($case) => [$case->value => $case->label()])
    ->toArray();
// Eredmény: ['admin' => 'Admin', 'commenter' => 'Commenter', 'user' => 'User']

// Blade template-ben
@foreach(RulesEnum::cases() as $case)
    <option value="{{ $case->value }}">{{ $case->label() }}</option>
@endforeach
```

### Model-ben használat

```php
class User extends Model
{
    protected $casts = [
        'role' => RulesEnum::class
    ];
}

// Használat
$user = new User();
$user->role = RulesEnum::Admin;
$user->save();

// Visszaolvasás
echo $user->role->label(); // 'Admin'
```

### Feltételes logika

```php
if ($user->role === RulesEnum::Admin) {
    // Admin specifikus logika
}

// Vagy switch/match használata
$permissions = match($user->role) {
    RulesEnum::Admin => ['create', 'read', 'update', 'delete'],
    RulesEnum::Commenter => ['read', 'comment'],
    RulesEnum::User => ['read'],
};
```

## Előnyök

### 1. **Type Safety**

- Nem tudsz érvénytelen szerepköröket használni
- A PHP fordítási időben ellenőrzi a típusokat

### 2. **IDE támogatás**

- Autocomplete és hibaellenőrzés
- Refactoring támogatás

### 3. **Karbantarthatóság**

- Egy helyen vannak a szerepkörök definiálva
- Könnyen bővíthető új szerepkörökkel

### 4. **Adatbázis konzisztencia**

- Csak ezek az értékek kerülhetnek be az adatbázisba
- Hibás értékek kiszűrése

### 5. **Teljesítmény**

- Gyorsabb, mint string összehasonlítások
- Memória hatékony

## Migration példa

```php
// Migration fájlban
Schema::table('users', function (Blueprint $table) {
    $table->enum('role', ['admin', 'commenter', 'user'])->default('user');
});
```

## Bővítési lehetőségek

### Több metódus hozzáadása

```php
public function permissions(): array
{
    return match($this) {
        self::Admin => ['create', 'read', 'update', 'delete'],
        self::Commenter => ['read', 'comment'],
        self::User => ['read'],
    };
}

public function isAdmin(): bool
{
    return $this === self::Admin;
}
```

### Színek hozzáadása UI-hoz

```php
public function color(): string
{
    return match($this) {
        self::Admin => '#dc2626',      // piros
        self::Commenter => '#2563eb',  // kék
        self::User => '#16a34a',       // zöld
    };
}
```

## Összefoglalás

Ez a `RulesEnum` egy **modern, type-safe megoldás** a felhasználói szerepkörök kezelésére Laravel alkalmazásokban. A PHP 8.1+ enum funkcióját használja, ami jelentős előnyöket nyújt a hagyományos string konstansokkal vagy osztály konstansokkal szemben.

**Legfontosabb jellemzők:**

- Type safety
- IDE támogatás
- Egyszerű használat
- Jó teljesítmény
- Könnyen bővíthető

Ez a módszer ajánlott minden Laravel projektben, ahol rögzített értékekkel (szerepkörök, státuszok, kategóriák stb.) kell dolgozni.
