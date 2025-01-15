document.addEventListener('DOMContentLoaded', () => {
    const components = document.querySelectorAll('.car-deals-container');
    console.log(`Found ${components.length} deal components on the page.`);

    components.forEach((component, index) => {
        const header = component.querySelector('.header');
        header.textContent += ` (Component ${index + 1})`;
    });
});
