function toggleAdditionalInfo(param) {
    let columnSection = document.querySelector('.column-section-'+param);
    let productBox = document.querySelector('.product-box');
    if (columnSection.style.display === 'none') {
        columnSection.style.display = 'flex';
        productBox.style.height = 'auto';
        document.getElementById('see-more-'+param).innerHTML = "Read Less";
    } else {
        columnSection.style.display = 'none';
        productBox.style.height = 'auto';
        document.getElementById('see-more-'+param).innerHTML = "Read More";
    }
}