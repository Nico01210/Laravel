@extends('layout')

@section('title', 'Mon panier')

@section('content')
    <div class="container">
        <div class="cart-page">
            <div class="cart-header">
                <h1>Mon panier</h1>
                <a href="{{ route('acheter') }}" class="btn-back">← Continuer mes achats</a>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if($products->count() > 0)
                <div class="cart-items">
                    @foreach($products as $product)
                        <div class="cart-item">
                            <div class="item-image">
                                @if($product->image)
                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="cart-product-image">
                                @else
                                    <img src="{{ asset('images/default-product.jpg') }}" alt="{{ $product->name }}" class="cart-product-image">
                                @endif
                            </div>
                            
                            <div class="item-details">
                                <h3>{{ $product->name }}</h3>
                                @if($product->category)
                                    <p class="item-category">{{ $product->category->name }}</p>
                                @endif
                                <p class="item-state">État : {{ strtoupper($product->etat) }}</p>
                            </div>
                            
                            <div class="item-quantity">
                                <label>Quantité : {{ $product->pivot->quantity }}</label>
                            </div>
                            
                            <div class="item-price">
                                <span class="unit-price">{{ $product->price }}€</span>
                                <span class="total-price">{{ $product->price * $product->pivot->quantity }}€</span>
                            </div>
                            
                            <div class="item-actions">
                                <form action="{{ route('cart.remove', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-remove" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="cart-summary">
                    <div class="total-section">
                        <h3>Total : {{ $total }}€</h3>
                        <div class="cart-actions">
                            <button class="btn btn-primary btn-large" onclick="confirmerPaiement()">Procéder au paiement</button>
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-cart">
                    <h2>Votre panier est vide</h2>
                    <p>Découvrez nos produits et ajoutez-les à votre panier !</p>
                    <a href="{{ route('acheter') }}" class="btn btn-primary">Voir les produits</a>
                </div>
            @endif
        </div>
    </div>

<script>
function confirmerPaiement() {
    alert('🎉 Merci pour votre commande !\n\nVotre paiement a été validé avec succès.\nVous recevrez un email de confirmation sous peu.\n\n💝 Bons jeux !');
    
    // Vider le panier après confirmation
    fetch('{{ route("cart.clear") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Recharger la page pour afficher le panier vide
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        // Recharger quand même la page
        window.location.reload();
    });
}
</script>

@endsection
