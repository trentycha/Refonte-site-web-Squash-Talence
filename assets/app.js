import './styles/app.css';

document.addEventListener('DOMContentLoaded', () => {
    const reserver = document.querySelectorAll('.slot');
    const resa = document.getElementById('monBouton');

    reserver.forEach(slot => {
        slot.addEventListener('mouseover', () => {
            resa.textContent = "Je réserve !";
            resa.style.color = 'white'; 
        });

        slot.addEventListener('mouseout', () => {
            resa.textContent = "";
        });

        slot.addEventListener('click', () => {
            window.location.href = '/resa_calendrier/index.html.twig';
        });
    });
});
