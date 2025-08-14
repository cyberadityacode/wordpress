jQuery(document).ready(function($) {
    // Format bytes to human-readable string
    const formatBytes = (bytes) => {
        if (!bytes || bytes <= 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return (bytes / Math.pow(k, i)).toFixed(2) + ' ' + sizes[i];
    };

    // Check if performance.memory is supported
    if (performance && performance.memory && performance.memory.usedJSHeapSize) {
        $('#memory-usage').text(
            formatBytes(performance.memory.usedJSHeapSize)
        );
    } else {
        $('#memory-usage').text('Memory info not available');
    }
});
