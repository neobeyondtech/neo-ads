<!-- WhatsApp Floating Button -->
<a href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ urlencode(config('services.whatsapp.default_message')) }}" 
   target="_blank" 
   class="whatsapp-float" 
   aria-label="Chat on WhatsApp">
    <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
        <path d="M16 0c-8.837 0-16 7.163-16 16 0 2.825 0.737 5.607 2.137 8.048l-2.137 7.952 7.933-2.127c2.42 1.37 5.173 2.127 8.067 2.127 8.837 0 16-7.163 16-16s-7.163-16-16-16zM16 29.467c-2.482 0-4.908-0.646-7.07-1.87l-0.507-0.292-5.045 1.351 1.344-5.003-0.325-0.527c-1.321-2.166-2.022-4.671-2.022-7.257 0-7.51 6.11-13.62 13.62-13.62s13.62 6.11 13.62 13.62-6.11 13.62-13.62 13.62zM21.524 18.842c-0.245-0.122-1.448-0.715-1.673-0.796s-0.387-0.122-0.551 0.122c-0.163 0.245-0.633 0.796-0.776 0.959s-0.286 0.184-0.531 0.061c-0.245-0.122-1.035-0.381-1.97-1.216-0.728-0.649-1.22-1.451-1.363-1.696s-0.015-0.378 0.107-0.5c0.11-0.108 0.245-0.286 0.367-0.429s0.163-0.245 0.245-0.408c0.082-0.163 0.041-0.306-0.020-0.429s-0.551-1.327-0.755-1.817c-0.2-0.48-0.402-0.414-0.551-0.422-0.143-0.008-0.306-0.010-0.469-0.010s-0.429 0.061-0.653 0.306c-0.224 0.245-0.857 0.837-0.857 2.041s0.878 2.368 1.0 2.531c0.122 0.163 1.726 2.633 4.18 3.691 0.584 0.251 1.040 0.401 1.395 0.513 0.586 0.186 1.119 0.16 1.541 0.097 0.469-0.070 1.448-0.592 1.653-1.163s0.204-1.061 0.143-1.163c-0.061-0.102-0.224-0.163-0.469-0.286z" fill="currentColor"/>
    </svg>
    <span class="whatsapp-text">Chat</span>
</a>

<style>
.whatsapp-float {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    background-color: #25D366;
    color: white;
    border-radius: 50px;
    text-align: center;
    font-size: 30px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.3);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    text-decoration: none;
    overflow: hidden;
}

.whatsapp-float svg {
    width: 32px;
    height: 32px;
    transition: transform 0.3s ease;
}

.whatsapp-float:hover {
    background-color: #128C7E;
    transform: scale(1.1);
    width: 140px;
    border-radius: 30px;
}

.whatsapp-float:hover svg {
    transform: scale(0.9);
    margin-right: 8px;
}

.whatsapp-text {
    display: none;
    font-size: 16px;
    font-weight: 600;
    white-space: nowrap;
}

.whatsapp-float:hover .whatsapp-text {
    display: inline;
}

/* Animation */
@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
    }
    70% {
        box-shadow: 0 0 0 15px rgba(37, 211, 102, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
    }
}

.whatsapp-float {
    animation: pulse 2s infinite;
}

.whatsapp-float:hover {
    animation: none;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .whatsapp-float {
        bottom: 15px;
        right: 15px;
        width: 50px;
        height: 50px;
    }
    
    .whatsapp-float svg {
        width: 28px;
        height: 28px;
    }
    
    .whatsapp-float:hover {
        width: 50px;
        border-radius: 50px;
    }
    
    .whatsapp-text {
        display: none !important;
    }
}
</style>