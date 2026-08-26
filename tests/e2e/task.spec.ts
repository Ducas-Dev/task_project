import { test, expect } from '@playwright/test';

test('la page des tâches est accessible', async ({ page }) => {
    await page.goto('/tasks');

    await expect(page).toHaveURL(/tasks/);
});
