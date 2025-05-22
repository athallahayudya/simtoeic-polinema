document.addEventListener('DOMContentLoaded', function() {
    // Function to update the counts
    function updateUserCounts() {
        fetch('/api/user-statistics')
            .then(response => response.json())
            .then(data => {
                // Update each count with a visual indication of change
                updateCountElement('staff-count', data.staffCount);
                updateCountElement('student-count', data.studentCount);
                updateCountElement('alumni-count', data.alumniCount);
                updateCountElement('lecturer-count', data.lecturerCount);
                
                // Update the last updated time
                document.getElementById('last-updated').textContent = 
                    'Last updated: ' + new Date().toLocaleTimeString();
            })
            .catch(error => console.error('Error fetching user statistics:', error));
    }
    
    // Helper function to update an individual count with visual feedback
    function updateCountElement(id, newValue) {
        const element = document.getElementById(id);
        const currentValue = parseInt(element.textContent);
        
        // Only apply the animation if the value has changed
        if (currentValue !== newValue) {
            element.textContent = newValue;
            element.classList.add('updated');
            
            // Remove the highlight effect after a short delay
            setTimeout(() => {
                element.classList.remove('updated');
            }, 1000);
        }
    }
    
    // Update counts immediately
    updateUserCounts();
    
    // Then update every 30 seconds
    setInterval(updateUserCounts, 30000);
});