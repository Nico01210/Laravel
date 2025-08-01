<?PHP 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'price', 'stock', 'etat'];

    // Relation avec les produits
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}