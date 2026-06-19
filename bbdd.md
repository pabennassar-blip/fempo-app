# FEMPO - Base de Dades: Taules i Relacions Eloquent

## 📊 TAULES PRINCIPALS

### 1. users
**Descripció:** Taula principal d'usuaris del sistema

| Columna | Tipus | Propietats |
|---------|-------|-----------|
| id | bigint | PK, Auto-increment |
| name | string | Required |
| email | string | Unique, Required |
| email_verified_at | timestamp | Nullable |
| password | string | Required |
| remember_token | string | Nullable |
| created_at | timestamp | Auto |
| updated_at | timestamp | Auto |

**Relacions Eloquent:**
- `contracts()` → BelongsToMany Contract
- `professor()` → HasOne Professor
- `tutor()` → HasOne Tutor
- `alumne()` → HasOne Alumne
- `empresari()` → HasOne Empresari

---

### 2. professors
**Descripció:** Rol de professor

| Columna | Tipus | Propietats |
|---------|-------|-----------|
| id | bigint | PK, Auto-increment |
| user_id | bigint | FK → users (onDelete: cascade) |
| curs | string | Required |
| created_at | timestamp | Auto |
| updated_at | timestamp | Auto |

**Relacions Eloquent:**
- `user()` → BelongsTo User
- `alumnes()` → BelongsToMany Alumne (pivot: professor_alumne)

---

### 3. tutors (NOU)
**Descripció:** Rol de tutor

| Columna | Tipus | Propietats |
|---------|-------|-----------|
| id | bigint | PK, Auto-increment |
| user_id | bigint | FK → users (onDelete: cascade) |
| created_at | timestamp | Auto |
| updated_at | timestamp | Auto |

**Relacions Eloquent:**
- `user()` → BelongsTo User
- `alumnes()` → BelongsToMany Alumne (pivot: tutor_alumne)

---

### 4. alumnes
**Descripció:** Rol d'alumne/estudiant

| Columna | Tipus | Propietats |
|---------|-------|-----------|
| id | bigint | PK, Auto-increment |
| user_id | bigint | FK → users (onDelete: cascade) |
| numero_seguretat_social | string | Required |
| created_at | timestamp | Auto |
| updated_at | timestamp | Auto |

**Relacions Eloquent:**
- `user()` → BelongsTo User
- `professors()` → BelongsToMany Professor (pivot: professor_alumne)
- `tutors()` → BelongsToMany Tutor (pivot: tutor_alumne)

---

### 5. empresaris
**Descripció:** Rol d'empresari

| Columna | Tipus | Propietats |
|---------|-------|-----------|
| id | bigint | PK, Auto-increment |
| user_id | bigint | FK → users (onDelete: cascade) |
| empresa_id | bigint | FK → empresas (onDelete: cascade) |
| created_at | timestamp | Auto |
| updated_at | timestamp | Auto |

**Relacions Eloquent:**
- `user()` → BelongsTo User
- `empresa()` → BelongsTo Empresa

---

### 6. empresas
**Descripció:** Empreses/Organitzacions

| Columna | Tipus | Propietats |
|---------|-------|-----------|
| id | bigint | PK, Auto-increment |
| title | string | Required |
| logo | string | Nullable |
| description | text | Nullable |
| location | string | Nullable |
| telefon | string | Nullable |
| nom_empresari | string | Nullable |
| created_at | timestamp | Auto |
| updated_at | timestamp | Auto |

**Relacions Eloquent:**
- `empresari()` → HasOne Empresari
- `empresaris()` → HasMany Empresari

---

### 7. contracts
**Descripció:** Contractes

| Columna | Tipus | Propietats |
|---------|-------|-----------|
| id | bigint | PK, Auto-increment |
| name | string | Required |
| created_at | timestamp | Auto |
| updated_at | timestamp | Auto |

**Relacions Eloquent:**
- `users()` → BelongsToMany User (pivot: contract_user)

---

### 8. jornades
**Descripció:** Sessions/Jornades de treball

| Columna | Tipus | Propietats |
|---------|-------|-----------|
| id | bigint | PK, Auto-increment |
| user_id | bigint | FK → users (onDelete: cascade) |
| data | date | Required |
| hora_entrada | time | Required |
| hora_sortida | time | Nullable |
| activitats | text | Nullable |
| created_at | timestamp | Auto |
| updated_at | timestamp | Auto |

**Relacions Eloquent:**
- `user()` → BelongsTo User
- `ras()` → BelongsToMany Ra (pivot: jornada_ra)

---

### 9. ras
**Descripció:** Resultats d'Aprenentatge (Learning Outcomes)

| Columna | Tipus | Propietats |
|---------|-------|-----------|
| id | bigint | PK, Auto-increment |
| resultat_aprenentatge_codi | string | FK → resultats_aprenentatge.codi (onDelete: cascade) |
| ra | text | Required |
| descripcio | text | Nullable |
| created_at | timestamp | Auto |
| updated_at | timestamp | Auto |

**Relacions Eloquent:**
- `resultatAprenentatge()` → BelongsTo ResultatsAprenentatge
- `jornades()` → BelongsToMany Jornada (pivot: jornada_ra)

---

### 10. resultats_aprenentatge
**Descripció:** Mòduls/Resultats d'Aprenentatge

| Columna | Tipus | Propietats |
|---------|-------|-----------|
| codi | string | PK (no auto-increment) |
| modul | string | Required |
| created_at | timestamp | Auto |
| updated_at | timestamp | Auto |

**Relacions Eloquent:**
- `ras()` → HasMany Ra

---

## 🔗 TAULES PIVOT (Many-to-Many)

### contract_user
Relació entre usuaris i contractes

| Columna | Tipus |
|---------|-------|
| id | bigint |
| contract_id | bigint (FK → contracts) |
| user_id | bigint (FK → users) |
| created_at | timestamp |
| updated_at | timestamp |

---

### professor_alumne
Relació entre professors i alumnes (1 professor → N alumnes)

| Columna | Tipus | Propietats |
|---------|-------|-----------|
| id | bigint | PK |
| professor_id | bigint | FK → professors (onDelete: cascade) |
| alumne_id | bigint | FK → alumnes (onDelete: cascade) |
| created_at | timestamp | Auto |
| updated_at | timestamp | Auto |
| Unique | - | (professor_id, alumne_id) |

---

### tutor_alumne
Relació entre tutors i alumnes (1 tutor → N alumnes)

| Columna | Tipus | Propietats |
|---------|-------|-----------|
| id | bigint | PK |
| tutor_id | bigint | FK → tutors (onDelete: cascade) |
| alumne_id | bigint | FK → alumnes (onDelete: cascade) |
| created_at | timestamp | Auto |
| updated_at | timestamp | Auto |
| Unique | - | (tutor_id, alumne_id) |

---

### jornada_ra
Relació entre jornades i RAs (1 jornada → N RAs)

| Columna | Tipus | Propietats |
|---------|-------|-----------|
| jornada_id | bigint | FK → jornades (cascadeOnDelete) |
| ra_id | bigint | FK → ras (cascadeOnDelete) |
| Unique | - | (jornada_id, ra_id) |

---

## 📈 DIAGRAMA DE RELACIONS
users (1) ──────────────→ (1) professors ──────→ (N) alumnes
│ ↑
├──→ (1) tutors ──────────────────────
│
├──→ (1) alumnes ──→ (N) professors (via professor_alumne)
│ ──→ (N) tutors (via tutor_alumne)
│
├──→ (1) empresaris ──→ (1) empresas
│
├──→ (N) contracts (via contract_user)
│
└──→ (N) jornades ──→ (N) ras (via jornada_ra)
↑
│
resultats_aprenentatge (1) ──→ (N) ras

---

## 📋 RESUMEN DE RELACIONS PER MODEL

| Model | Relacions |
|-------|-----------|
| **User** | contracts (BT M), professor (1:1), tutor (1:1), alumne (1:1), empresari (1:1) |
| **Professor** | user (BT), alumnes (BT M via professor_alumne) |
| **Tutor** | user (BT), alumnes (BT M via tutor_alumne) |
| **Alumne** | user (BT), professors (BT M via professor_alumne), tutors (BT M via tutor_alumne) |
| **Empresari** | user (BT), empresa (BT) |
| **Empresa** | empresari (1:1), empresaris (1:N) |
| **Contract** | users (BT M via contract_user) |
| **Jornada** | user (BT), ras (BT M via jornada_ra) |
| **Ra** | resultatAprenentatge (BT), jornades (BT M via jornada_ra) |
| **ResultatsAprenentatge** | ras (1:N) |

---

## 🔑 NOTES IMPORTANTS

1. **Rol de tutor (NOU):** Afegit a la versió actual. Els tutors poden tenir N alumnes assignats.

2. **Relacions professors-alumnes:** Els professors poden tenir múltiples alumnes. Els alumnes poden tenir múltiples professors.

3. **Relacions tutors-alumnes:** Els tutors poden tenir múltiples alumnes. Els alumnes poden tenir múltiples tutors.

4. **Taula resultats_aprenentatge:** Usa `codi` com a clau primària (no auto-increment). Les RAs es relacionen per aquest codi.

5. **Jornades:** Cada jornada pertany a 1 usuari i pot estar relacionada amb múltiples RAs.

6. **Empresaris:** Cada empresari és vinculat a una empresa específica i a un usuari.

7. **Cascading deletes:** Les relacions més importants usen `onDelete('cascade')` per mantenir la integritat.