# Instructions

- Following Playwright test failed.
- Explain why, be concise, respect Playwright best practices.
- Provide a snippet of code with the fix, if possible.

# Test info

- Name: task.spec.ts >> Créer une nouvelle tâche
- Location: tests/e2e/task.spec.ts:10:1

# Error details

```
Error: expect(locator).toBeVisible() failed

Locator: getByText('Mes tâches')
Expected: visible
Timeout: 5000ms
Error: element(s) not found

Call log:
  - Expect "toBeVisible" with timeout 5000ms
  - waiting for getByText('Mes tâches')

```

```yaml
- main:
  - heading "404" [level=1]
  - text: Not Found
```

# Test source

```ts
  1  | import { test, expect } from '@playwright/test';
  2  | 
  3  | test('la page des tâches est accessible', async ({ page }) => {
  4  |     await page.goto('/tasks');
  5  | 
  6  |     await expect(page).toHaveURL(/tasks/);
  7  | });
  8  | 
  9  | 
  10 | test('Créer une nouvelle tâche', async ({ page }) => {
  11 |     // Aller sur la page "Mes tâches"
  12 |     await page.goto('http://localhost:8000/tasks');
  13 | 
  14 |     // Vérifier que la page est bien chargée
> 15 |     await expect(page.getByText('Mes tâches')).toBeVisible();
     |                                                ^ Error: expect(locator).toBeVisible() failed
  16 | 
  17 |     // Cliquer sur "+ Nouvelle tâche"
  18 |     await page.getByRole('link', { name: '+ Nouvelle tâche' }).click();
  19 | 
  20 |     // Vérifier qu'on est sur la page de création
  21 |     await expect(page).toHaveURL(/create-task/);
  22 | 
  23 |     // Remplir le formulaire
  24 |     await page.getByLabel('Tâche').fill('Faire les tests Playwright');
  25 | 
  26 |     await page.getByLabel('Description').fill(
  27 |         'Créer une tâche automatiquement avec Playwright'
  28 |     );
  29 | 
  30 |     await page.getByLabel('Priorité').selectOption('moyenne');
  31 | 
  32 |     await page.getByLabel('Statut').selectOption('en_attente');
  33 | 
  34 |     await page.getByLabel('Date d’échéance').fill('2026-09-01');
  35 | 
  36 |     // Soumettre le formulaire
  37 |     await page.getByRole('button', { name: /créer|ajouter|enregistrer/i }).click();
  38 | 
  39 |     // Vérifier le retour sur la page des tâches
  40 |     await expect(page).toHaveURL(/tasks/);
  41 | 
  42 |     // Vérifier que la tâche apparaît
  43 |     await expect(
  44 |         page.getByText('Faire les tests Playwright')
  45 |     ).toBeVisible();
  46 | });
  47 | 
  48 | 
  49 | 
```