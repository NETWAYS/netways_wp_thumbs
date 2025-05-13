document.addEventListener('DOMContentLoaded', function () {
    const useET = netwaysThumbs.useETmodules;

    // Load Font Awesome if Divi/ETmodules is not used
    if (!useET) {
        const fa = document.createElement('link');
        fa.rel = 'stylesheet';
        fa.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css';
        document.head.appendChild(fa);
    }

    // Inject icons into buttons
    document.querySelectorAll('.icon-holder').forEach(el => {
        const type = el.dataset.icon;
        const icon = document.createElement('span');

        if (useET) {
            icon.className = 'et-icon';
            icon.innerHTML = type === 'up' ? '&#xe106;' : '&#xe0eb;';
            icon.setAttribute('aria-hidden', 'true');
        } else {
            icon.className = `fa-icon fas fa-thumbs-${type}`;
            icon.setAttribute('aria-hidden', 'true');
        }

        el.appendChild(icon);
    });

    // Voting logic
    document.querySelectorAll('.netways-thumb-btn').forEach(button => {
        button.addEventListener('click', function () {
            const container = this.closest('.netways-thumb-container');
            const postId = container.dataset.postId;
            const vote = this.dataset.vote;
            const storageKey = 'netways_thumb_' + postId;

            if (localStorage.getItem(storageKey)) {
                alert('You have already voted!');
                return;
            }

            const formData = new FormData();
            formData.append('action', 'netways_vote');
            formData.append('post_id', postId);
            formData.append('vote', vote);
            formData.append('nonce', netwaysThumbs.nonce);

            fetch(netwaysThumbs.ajax_url, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.querySelector('.netways-thumb-count').textContent = data.data.new_count;
                    localStorage.setItem(storageKey, vote);
                }
            })
            .catch(err => console.error('Voting failed:', err));
        });
    });
});

