document.querySelectorAll('.has-dropdown > .option-link').forEach(link => {
    link.addEventListener('click', (e) => {
      e.preventDefault();
  
      const li = link.closest('.has-dropdown');
      const dropdown = li.querySelector('.dropdown');
      const isOpen = li.classList.contains('open');
  
      if (isOpen) {
        // Fecha o atual e todos os subdropdowns dentro dele
        li.classList.remove('open');
        dropdown.classList.remove('open');
        li.querySelectorAll('.has-dropdown.open').forEach(subLi => {
          subLi.classList.remove('open');
          const subDropdown = subLi.querySelector('.dropdown');
          if (subDropdown) subDropdown.classList.remove('open');
        });
      } else {
        // Fecha outros irmãos no mesmo nível
        const siblings = li.parentElement.querySelectorAll(':scope > .has-dropdown');
        siblings.forEach(sibling => {
          sibling.classList.remove('open');
          const sibDropdown = sibling.querySelector('.dropdown');
          if (sibDropdown) sibDropdown.classList.remove('open');
  
          // Fecha os subdropdowns dos irmãos também
          sibling.querySelectorAll('.has-dropdown.open').forEach(subLi => {
            subLi.classList.remove('open');
            const subDropdown = subLi.querySelector('.dropdown');
            if (subDropdown) subDropdown.classList.remove('open');
          });
        });
  
        // Abre o atual
        li.classList.add('open');
        dropdown.classList.add('open');
      }
    });
  });
  