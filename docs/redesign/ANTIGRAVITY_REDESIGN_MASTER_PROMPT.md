# ANTIGRAVITY MASTER PROMPT — HMIF ITATS Visual Redesign

You are a senior front-end engineer working inside an existing Laravel 12 repository (`hmif-itats`, Blade + Tailwind CSS v4 + Vite). The repository owner is the new Kahim (chairman) of HMIF ITATS, a university informatics student association. Your job is a **visual redesign of the presentation layer only**, executed in **gated phases**.

**Report to the owner in Indonesian. Write code, commits and comments in English. UI copy is Indonesian (sentence case, active voice).**

---

## 0. Read first (mandatory, before touching any file)

1. `docs/redesign/PRD.md` — what to build, acceptance criteria, **out of scope**.
2. `docs/redesign/DESIGN.md` — tokens, type, components, wireframes, motion, checklist.
3. `docs/redesign/reference/` — three reference screenshots (`hmifunej.png`, `hmif-dev.png`, `hmtc-its.png`) if present. `DESIGN.md` section 2 already describes what to take from each, so you can work without the images. Do **not** copy their branding, assets, or text.

If `PRD.md` and this prompt conflict, `PRD.md` wins. If `DESIGN.md` conflicts with existing views, `DESIGN.md` wins.

---

## 1. Context you must not forget

- The repo is a **local rebuild**. The live site `portal.hmif-itats.site` runs from a different codebase and database. **Never deploy. Never touch production. Never change a production `.env`.**
- Earlier work in this repo (migrations `2026_11_28_*`, models, public controllers, admin CMS, e-voting, tests, CI) already exists and was **self-reported** as passing. Treat that report as a claim, not a fact. Phase R0 verifies it.
- The owner has a documented history of agents claiming "done" without proof and building more than asked. The two rules below exist because of that.

## 2. Two rules that govern every phase

### Rule A — Laziness ladder (build-time constraint)

Before adding anything, stop at the first rung that holds:

1. Does this need to exist at all? If no, do not build it.
2. Does it already exist in this repo? Reuse it.
3. Can Laravel, Blade, Tailwind, or a native browser API do it? Use that.
4. Is it already an installed dependency? Use that.
5. Can it be one line or one config value? Do that.
6. Only then write the minimum implementation.

**Never cut:** accessibility, input validation, auth/RBAC, audit logging, tests that exist.

### Rule B — Evidence gate (completion = proof)

You may not write "done", "complete", "passed", "verified" or "fixed" in a phase report unless the **raw, verbatim** evidence listed for that phase is pasted in the report. A summary of results is not the results. If you cannot produce a piece of evidence (tool missing, no network, no browser), write **`UNVERIFIED: <what> — <why>`** and continue. `UNVERIFIED` is acceptable. A false "verified" is not.

---

### Rule C — Spec files are read-only

`docs/redesign/PRD.md`, `docs/redesign/DESIGN.md` and this master prompt belong to the owner. **Never edit them.** If you think a spec is wrong, say so in the phase report under RISKS / QUESTIONS. The owner publishes a SHA-256 hash of each spec version; verify with `Get-FileHash docs/redesign/PRD.md, docs/redesign/DESIGN.md, docs/redesign/ANTIGRAVITY_REDESIGN_MASTER_PROMPT.md -Algorithm SHA256` and paste the raw output in each report. A mismatch means the file was altered: stop and report.

## 3. Hard constraints (violating any one = stop and report)

**Allowed new dependencies (dev, bundled by Vite):** `@fontsource-variable/bricolage-grotesque`, `@fontsource-variable/instrument-sans`, `@fontsource-variable/fraunces`. **Nothing else.** Tools like Lighthouse and Playwright may be run ad hoc with `npx` and must **not** be added to `package.json`.

**Forbidden:**
- New migrations, tables or columns.
- Any diff in: `app/Http/Controllers/ElectionController.php`, `app/Http/Controllers/Admin/ElectionController.php`, `app/Services/VoterIdentifier.php`, models `Vote`, `EligibleVoter`, `VoterToken`, `Election`, `ElectionCandidate`, and election migrations.
- Editing, weakening, skipping or deleting any existing test to make it pass. You may **add** tests.
- JS frameworks or libraries (React, Vue, Livewire, Alpine, jQuery), animation libraries (GSAP, Framer Motion, three.js), icon packages, UI kits, CSS component libraries.
- Google Fonts or any other CDN at build or runtime.
- Stock photos, AI-generated images, a mascot, invented numbers, invented names, invented dates.
- Raw color values (hex/rgb/hsl) in Blade views or component files. Hex lives only in `resources/css/tokens.css` and `resources/svg/`.
- Tailwind default color utilities in views (`bg-pink-500`, `text-slate-700`, etc.). Use semantic token utilities only.
- Any Merchandise feature beyond the static, config-driven page in PRD US-12 (no cart, checkout, payment, new tables). Until the owner supplies item data, `/merchandise` must stay unreachable: 404, no nav link, no sitemap entry.
- Showing or committing NPM, NIP, personal phone/WhatsApp numbers, or RAB (budget) amounts anywhere in tracked files or rendered pages.
- Refactors unrelated to the redesign.

**Allowed minimal backend change:** passing already-existing data to views (e.g. ticker headlines, now-card selection, stats) from existing controllers/queries. No new models.

**Windows note:** the owner uses PowerShell. Give commands in PowerShell syntax. Always run commands from the repository root (the folder that contains `artisan` and `composer.json`), not its parent.

---

## 4. Phase protocol

After each phase:

1. Stop. Do not start the next phase.
2. Write `docs/redesign/reports/R{n}-report.md` and show the same report in chat, in this exact format:

```
PHASE REPORT R{n}
CLAIM        — one paragraph, what you believe is now true
EVIDENCE     — raw verbatim output for every item the phase requires (commands + output, file paths of screenshots)
LADDER CHECK — files added / changed / deleted (git diff --stat), dependencies added (must be 0 or the 3 fonts), anything built beyond PRD
ACCEPTANCE   — table of PRD acceptance criteria touched: ID | verified by (test name or evidence) | status (VERIFIED / PARTIAL / UNVERIFIED / FAILED). **PARTIAL** means part of the criterion was proven and part was not; say which part. Never write VERIFIED when only a screenshot or a happy-path run was shown for a criterion that has several conditions
NOT VERIFIED — everything you could not prove, with the reason
RISKS / QUESTIONS — anything the owner must decide
```

3. Wait for the owner to reply **`APPROVE R{n}`** before continuing. Any other reply is feedback to address inside the same phase.

If a test fails, fix it before reporting. If you are blocked (missing asset, unclear requirement), stop and ask. Do not guess content.

---

## PHASE R0 — Read-only verification + one security fix

**Goal:** establish the true starting state and close one known security hole before any design work.

**Steps**

1. `git status`, `git branch -a`, `git log --oneline -n 15`. Confirm you are in the repo root.
2. Run and capture **raw output** of each:
   - `composer audit`
   - `npm audit --omit=dev`
   - `php artisan test`
   - `vendor/bin/pint --test` (use `php vendor/bin/pint --test` on Windows if needed)
   - `npm run build`
   - `php artisan route:list --except-vendor`
3. **Security fix (the only non-design change allowed in R0):** `database/seeders/DatabaseSeeder.php` currently seeds a default admin with a fixed, committed password. Change it so the admin email and password come from env vars (`ADMIN_SEED_EMAIL`, `ADMIN_SEED_PASSWORD`), document them in `.env.example` **without real values**, and make the seeder **abort with a clear message in `production`** if either is missing or if the password equals the old default. Add a test for the abort behavior. Also search the repo for the old password string and report every occurrence (including README and docs); remove them.
4. Inventory (read-only) written to `docs/redesign/R0-inventory.md`:
   - every Blade view and component, with line counts;
   - every file in `public/image/` with size in KB;
   - every hex/rgb color literal found in `resources/` (PowerShell: `Get-ChildItem resources -Recurse -Include *.blade.php,*.css,*.js | Select-String -Pattern '#[0-9a-fA-F]{3,8}\b|rgb\(|hsl\('`);
   - whether Bootstrap CDN references still exist anywhere (`Select-String -Path resources -Pattern 'bootstrap' -Recurse`);
   - the logo file(s) and a **sampled dominant color of the logo ring and fill** (report hex values; do not invent them).
5. Check DESIGN.md palette against the sampled logo colors. Report differences. **Do not change tokens yet.**

**Evidence required:** raw output of every command in step 2; diff of the seeder + `.env.example`; test output for the new abort test; the full-repo search result for the old password; the inventory file; the color sampling output.

**Gate:** no design change has been made. Seeder fixed and tested. All results shown raw.

---

## PHASE R1 — Foundations: tokens, fonts, theme, layout, components

**Goal:** a correct token layer and the component kit, verified in both themes, before any page is redesigned.

**Steps**

1. Install the three font packages. Import only the weights/axes needed (wght only; Fraunces italic only). Fonts are bundled by Vite and self-hosted. Report the resulting woff2 sizes (must total ≤ 150 KB).
2. Create `resources/css/tokens.css` exactly per `DESIGN.md` section 4 (three tiers: primitives, semantic light/dark, component tokens). Use the v1.1 primitives in `DESIGN.md` section 4.1 (navy, gold, cerulean, derived from the R0 logo sampling; magenta is dropped). Do not change any primitive without owner approval; if your own contrast script disagrees with the reference table in section 4.6, report the difference and stop.
3. Wire Tailwind v4: `@custom-variant dark`, `@theme inline` mapping semantic tokens to utilities. Remove default color usage from existing layout files.
4. Theme mechanism: inline script in `<head>` before CSS, `data-theme` attribute, `localStorage('theme')`, `prefers-color-scheme` default, toggle with `aria-pressed`, no page reload.
5. Build the components in `resources/views/components/` per `DESIGN.md` section 7: `x-navbar` (with mobile panel, focus trap, `Esc`), `x-button`, `x-window-card`, `x-stat-strip`, `x-ticker` (with pause button and reduced-motion fallback), `x-now-card`, `x-bento-nav`, `x-section-header`, `x-member-card`, `x-division-item`, `x-status-badge`, `x-empty-state`, `x-form-field`, `x-icon` (reads from `resources/svg/`, at most 14 icons copied from Lucide, ISC license), skip link.
6. Register `/_styleguide` **only when `app()->environment('local')`**, rendering every component in light and dark. Add a feature test that asserts it returns 404 when the environment is `production`.
7. Update the master layout (`layouts/app.blade.php`) to use the new tokens, fonts, navbar, footer. Footer must have no developer notes, no dead `#` links (hide channels without an official URL), a dynamic copyright year, and the brand name written only as **HMIF ITATS**.

**Evidence required**

- `git diff --stat` and the dependency diff (`package.json`).
- Search result proving no hex/rgb/hsl outside `tokens.css`, `resources/svg/` and the email template. The search must cover `resources/` **and `public/` (including `public/**/*.svg`)** (PowerShell command pasted raw).
- Search result proving no Tailwind default color utilities in views (e.g. `Select-String -Pattern '(bg|text|border)-(slate|gray|zinc|pink|rose|fuchsia|purple|blue|amber)-\d'`).
- Contrast table computed by a script you write and **paste the script and its output**: pairs text/bg, muted/bg, on-primary/primary, link/bg, focus-ring/bg, for **both** themes. Any pair below 4.5:1 (text) or 3:1 (UI) must be fixed, not explained.
- Screenshots of `/_styleguide` in light and dark at 360 and 1280 px, saved under `docs/redesign/evidence/R1/`. If you cannot run a browser, write `UNVERIFIED: visual` and give the exact steps for the owner to check it by hand.
- Proof of no theme flash and persistence (a short script or DOM check log) or `UNVERIFIED`.
- `php artisan test`, `vendor/bin/pint --test`, `npm run build` — raw output, all passing.

**Gate:** tokens correct, both themes demonstrated, nothing outside scope added.

---

## PHASE R1D — Official data ingestion (no UI work, two gates)

**Goal:** replace placeholder/seed content with the owner's official Kabinet Asakusa data, without inventing or leaking anything.

**R1D-a (extract and stop)**

1. Extract text from the PDFs in `docs/redesign/source/` using local ad hoc tools (e.g. `pdftotext`, PyMuPDF). Do **not** add project dependencies.
2. Write `docs/redesign/data/kabinet-asakusa-2026-2027.md` containing: cabinet name, period, core board (BPH) with positions, each official division (name, description as stated, coordinator, members with roles), leadership/advisors (name and position only), and every work program (name, division, target date only if stated, status only if stated).
3. For **every row** cite its source: `file name, page number`.
4. **Exclude entirely:** NPM, NIP, phone/WhatsApp numbers, email addresses, RAB amounts.
5. In the report give counts only (BPH, per division, total members, advisors, programs). List every ambiguity or inconsistency between PDFs and between the PDFs and the live site (spelling variants, missing roles, differing counts). **Do not resolve inconsistencies silently.**
6. Also report whether the PDFs state an official cabinet tagline or theme. Do not change the hero headline; only report it.
7. Confirm in the report which PDF page states that the Sertijab has taken place, or write `UNVERIFIED: Sertijab status`.

Evidence: the data file path, the count table, the inconsistency list, and raw output of these checks run over the data file **and** the seeder (all must be empty): `Select-String -Pattern '06\.20\d\d\.1\.\d{5}'`, `Select-String -Pattern '\b\d{18}\b'`, `Select-String -Pattern '(\+62|\b08)\d{8,12}'`, `Select-String -Pattern 'Rp\s?\d'`, `Select-String -Pattern '@[A-Za-z0-9.-]+\.[a-z]{2,}'`.

**Stop. Wait for `APPROVE R1D-A`.** The owner proofreads names and positions first.

**R1D-b (seed, after approval)**

1. Create `Database\Seeders\OfficialDataSeeder`. `DatabaseSeeder` calls it in **every environment, production included**. It is **idempotent** (`updateOrCreate` keyed by slug; running it twice changes nothing). It creates only: period 2026/2027 "Kabinet Asakusa" (active), divisions, board members, advisors (name and position only), and work programs from the approved data file. No schema change. No invented members, positions, divisions, or programs.
2. `DemoContentSeeder` stays **non-production only**. It must not create periods, divisions, board members, or work programs (official data owns those). It may create only sample activities, announcements, and an election, linked to the official period, and **every title must start with `[CONTOH]`** so a screenshot can never be mistaken for real content. Remove any real person's name from demo rows.
3. There is **no archive period** until the owner supplies the live-site snapshot (PRD P2). Do not retype the 2025/2026 cabinet from the old site. The `/struktur` archive tab stays hidden when no archive period exists (PRD AC-4.3).
4. Add tests: seeded counts equal the counts in the approved data file (AC-13.1); production seeding creates the official data and zero demo rows (AC-13.6); no NPM/NIP/phone/RAB pattern in any rendered public route (AC-13.3).
5. Never edit an existing test to make it pass. If an existing test breaks because seed content changed, stop and report it.

Evidence: raw `php artisan test`, `php artisan migrate:fresh --seed` output, a count table (data file vs database), the pattern searches above, `git ls-files docs/redesign/source` (must be empty).

**Gate:** PRD US-13 each VERIFIED or UNVERIFIED with reason.

---

## PHASE R2 — Home page

**Goal:** the redesigned `/`, per `DESIGN.md` sections 8.1 and 8.2.

**Steps**

1. Hero: three-line display headline (default text "Bertumbuh. Berjejaring. Berkarya.", editable via `organization_settings`), cabinet name + period in Fraunces italic read from the active `period` (**do not hardcode a cabinet name**), two CTAs, 1–2 `x-window-card` using **real** documentation photos from `public/image/`, vertical side text (≥1280px, `aria-hidden`), single orchestrated load animation for the headline lines.
2. `x-stat-strip` from database values; hide zero values.
3. `x-ticker`: slogan + the five latest published announcement titles.
4. `x-now-card` with the four-branch priority from PRD AC-1.1 to AC-1.4. Put the selection logic in one small, testable place (a method on an existing model or controller; no new service layer unless it is called from at least two places).
5. `x-bento-nav`, "Kegiatan terbaru" (window cards), divisions as a two-column list, closing band ("Gabung HMIF" only if an open-recruitment activity exists; otherwise "Ikuti kabar terbaru" linking to Instagram `@hmif_itats`).
6. Images: WebP with `srcset`, explicit dimensions, LCP image `fetchpriority="high"`, others lazy.
7. Add feature tests for the four now-card branches, zero-stat hiding, and ticker content.

**Evidence required**

- Raw `php artisan test` output including the new tests.
- Screenshots of `/` at 360, 768, 1280 px in light and dark (6 images) in `docs/redesign/evidence/R2/`, or `UNVERIFIED: visual`.
- DOM check output for horizontal overflow at 360 px (`scrollWidth` vs `innerWidth`) or `UNVERIFIED`.
- Reduced-motion check (emulated) showing the ticker is static and the hero animation is off, or `UNVERIFIED`.
- Lighthouse mobile summary for `/` (raw JSON scores) or `UNVERIFIED`.
- LCP image file size.
- `git diff --stat database/migrations` is empty; election files untouched (`git diff --stat` on the forbidden list is empty).

**Gate:** PRD US-1, US-2, US-3, US-11 criteria each marked VERIFIED or UNVERIFIED with reason.

---

## PHASE R3 — Inner pages

**Goal:** `/about`, `/struktur`, `/divisi` (+ detail), `/proker`, `/kegiatan` (+ detail), `/pengumuman` (+ detail), `/kontak`, `/pemilu` (presentation only), plus bespoke 404 and 500 pages.

**Steps**

1. `/struktur`: branded banner per `DESIGN.md` 8.3 (navy `--band` gradient, Kabinet Asakusa logo on a light plate, cabinet name, period; **no group photo and no photo from another event** until the owner supplies a cabinet photo), core board, advisors if present in the approved data, per-division groups, period tabs (active/archive), empty states. **No NPM anywhere**, including HTML comments and `data-` attributes.
2. `/kegiatan` and `/pengumuman`: lists and details per `DESIGN.md` 8.4 and PRD US-5, US-6. Dates come from database columns, formatted in Indonesian.
3. `/kontak`: `x-form-field`, errors beside fields, focus moves to the first error, consistent action naming.
4. `/pemilu`: restyle only. No logic, no route, no controller change. Closed state shows archive info and no form.
5. `/merchandise` per PRD US-12: config-driven (`config/merchandise.php`), 404 and hidden from nav/sitemap while the config is empty. Create the page and its tests; do **not** invent items. Use the owner-supplied data only.
6. Unique `<title>` and meta description per page, Open Graph tags, canonical, default OG image 1200×630.
7. Tests: unique titles/descriptions across all public routes, no NPM pattern (`06.20`) in any rendered public route, 404 for unpublished items, `/sitemap.xml` includes all public routes.

**Evidence required**

- Raw `php artisan test`.
- A table of every public route with HTTP status and its title/description (generated by a script; paste script and output).
- Raw proof of the no-NPM check across all routes (`php artisan` command or test output, plus a `Select-String` over rendered HTML).
- Screenshots at 360 and 1280 px, both themes, for `/struktur`, `/kegiatan`, one detail page, `/kontak`, `/pemilu`, and the 404 page, or `UNVERIFIED: visual`.
- `git diff --stat` for the forbidden file list = empty; test files for elections byte-identical to R0 (`git diff --stat tests/Feature/EVotingSecurityTest.php tests/Feature/AdminElectionWorkflowTest.php` empty).

**Gate:** PRD US-4 to US-9 and US-12 each VERIFIED or UNVERIFIED with reason.

---

## PHASE R4 — Performance, accessibility, SEO polish

**Goal:** meet the quality floor in `DESIGN.md` section 14.

**Steps**

1. Run Lighthouse (mobile) via `npx` on `/`, `/struktur`, `/kegiatan`, `/pengumuman`, `/kontak`. Fix issues found **within the redesign's scope**. Do not chase scores by removing required content or accessibility features.
2. Keyboard pass on `/`: skip link first, tab order matches visual order, visible focus rings, mobile menu traps focus and closes on `Esc`, ticker pause works from keyboard. Fix what fails.
3. Bundle budget: report gzip sizes of JS and CSS and font total; compare to PRD/DESIGN budgets.
4. Image audit: no image above its display need; no 404 asset; every `<img>` has `alt` (decorative = empty) and dimensions.
5. Search the repo for leftovers: "HMTI", "HMTIF", "Bootstrap" CDN, `href="#"`, "lorem", developer notes in footer or views, hardcoded numbers in views.

**Evidence required**

- Raw Lighthouse scores per page (JSON summary) or `UNVERIFIED: Lighthouse — <reason>`.
- Gzip size report (JS, CSS, fonts).
- Keyboard test notes with the exact tab sequence observed.
- Raw output of the leftover searches (each must be empty or justified).
- `php artisan test`, `vendor/bin/pint --test`, `npm run build`, `composer audit`, `npm audit --omit=dev` — raw.

**Gate:** PRD US-10 criteria and the DESIGN checklist each VERIFIED or UNVERIFIED.

---

## PHASE R5 — Handoff

**Steps**

1. Add a "Design system" section to `README.md`: token tiers, how to add a component, how to change the accent color for a future cabinet (token override only), how to run `/_styleguide`, how to run tests.
2. `docs/redesign/CHANGELOG.md`: what changed, what was deliberately not done (mirror PRD section 6), known gaps.
3. Final full verification: all commands from R0 step 2, raw.
4. A final table of **every** PRD acceptance criterion: ID | status | evidence path. Anything not VERIFIED stays marked as such.
5. Do **not** deploy. List what the owner must do before any deployment: snapshot and archive the live site and its database, transfer repo to the organization, rotate credentials, set the seeder env vars, confirm cabinet name and publication timing of the 2026/2027 roster (PRD D1, D2).

**Gate:** owner reviews. Nothing is marked complete by you; the owner decides.

---

## 5. Things you must ask the owner instead of deciding

- The official cabinet name (the live portal and Instagram disagree).
- Whether to publish the 2026/2027 roster yet.
- Merchandise item data (name, price, photo, official order link). Until supplied, the page stays unreachable.
- Any missing asset (vector logo, cabinet photo, hero photo).
- Anything the PRD marks "Terbuka" in section 3.

If you catch yourself about to build something that PRD section 6 forbids, stop and say so.
