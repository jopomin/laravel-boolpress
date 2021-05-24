<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Post;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++) {
            $new_post = new Post ();

            $new_post->titolo = $faker->sentence(rand(2,6));
            $new_post->contenuto = $faker->text(rand(100,200));

            $slug = Str::slug($new_post->titolo, '-');
            $slug_base = $slug;

            $post_esiste = Post::where('slug', $slug)->first();
            $cont = 1;
            while($post_esiste) {
                $slug = $slug_base . '-' . $cont;
                $cont++;
                $post_esiste = Post::where('slug', $slug)->first();
            }

            $new_post->slug = $slug;
            $new_post->user_id = 1;
            $new_post->save();
        }
    }
}
