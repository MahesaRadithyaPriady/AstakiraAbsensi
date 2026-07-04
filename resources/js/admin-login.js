import { createIcons, icons } from 'lucide';

createIcons({ icons });

const toggle = document.getElementById('toggle-password');
const password = document.getElementById('password');

if (toggle && password) {
    toggle.addEventListener('click', () => {
        const isHidden = password.type === 'password';
        password.type = isHidden ? 'text' : 'password';

        const wrapper = toggle;
        wrapper.innerHTML = `<i data-lucide="${isHidden ? 'eye-off' : 'eye'}" class="h-5 w-5"></i>`;
        createIcons({ icons, nameAttr: 'data-lucide' });
    });
}
