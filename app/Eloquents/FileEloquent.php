<?php

namespace App\Eloquents;

use App\Eloquents\BaseEloquent;
use Illuminate\Validation\ValidationException;
use App\Exceptions\MoveFileException;
use Storage;
use Image;

class FileEloquent extends BaseEloquent {

    protected $model;

    public function __construct(\App\Models\File $model) {
        $this->model = $model;
    }

    public function rules() {
        return [
            'files.*' => 'mimes:jpeg,png,gif,bmp,svg|max:10240'
        ];
    }

    public function insert($file) {
        $size = $file->getClientSize();
        $name = $file->getClientOriginalName();
        $mimetype = $file->getClientMimeType();
        $extension = $file->getClientOriginalExtension();
        $type = $extension;

        if (in_array($extension, ['jpeg', 'png', 'bmp', 'gif', 'svg'])) {

            $type = 'image';
            $upload_dir = config('app.upload_dir');
            $rand_dir = makeRandDir(16, $this->model);
            $m_image = Image::make($file);
            $width = $m_image->width();
            $height = $m_image->height();
            $ratio = $width / $height;

            $sizes = config('app.image_sizes');

            if ($sizes) {
                foreach ($sizes as $key => $value) {
                    $w = $value['width'];
                    $h = $value['height'];

                    if ($w == null && $h == null) {
                        continue;
                    }

                    $rspath = $upload_dir . $key . '/' . $rand_dir . '/' . intval($w) . 'x' . intval($h) . '.' . $extension;

                    $crop = $value['crop'];
                    $r = ($h == null) ? 0 : $w / $h;

                    if ($width > $w && $height > $h) {
                        if ($ratio > $r) {
                            $rh = $h;
                            $rw = ($h == null) ? $w : $width * $h / $height;
                        } else {
                            $rw = $w;
                            $rh = ($w == null) ? $h : $height * $w / $width;
                        }
                        $sh = round(($rh - $h) / 2);
                        $sw = round(($rw - $w) / 2);

                        $rsImage = Image::make($file)->resize($rw, $rh, function($constraint) {
                            $constraint->aspectRatio();
                        });
                        if ($crop) {
                            $rsImage->crop($w, $h, $sw, $sh);
                        }

                        Storage::disk()->put($rspath, $rsImage->stream()->__toString());
                    }
                }
            }
        }

        $fullpath = $upload_dir . 'full/' . $rand_dir;
        $file->move($fullpath, $name);

        $item = new $this->model();
        $item->name = $name;
        $item->url = $fullpath . '/' . $name;
        $item->type = $type;
        $item->mimetype = $mimetype;
        $item->rand_dir = $rand_dir;
        $item->author_id = 1;

        return $item->save();
    }

    public function destroy($ids) {
        if (!is_array($ids)) {
            $ids = [$ids];
        }
        
        $sizes = config('app.image_sizes');
        $sizes['full'] = [];
        $dir = config('app.upload_dir');
        
        foreach ($ids as $id) {
            $image = $this->model->find($id);
            if ($image) {
                foreach ($sizes as $key => $size) {
                    $path = $dir . $key . '/' . $image->rand_dir;
                    if (Storage::disk()->exists($path)) {
                        Storage::disk()->deleteDirectory($path);
                    }
                }
                $image->delete();
            }
        }
    }

}
