let videoFrame = document.getElementById('videoFrame');
const targetEl = document.getElementById('video-modal');

const options = {
    placement: 'bottom-right',
    backdrop: 'dynamic',
    backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
    closable: true,
    onHide: () => {
        videoFrame.removeAttribute('src'); 
    },
    onShow: () => {
        videoFrame.src = '';
    },
};

const modal = new Modal(targetEl, options);