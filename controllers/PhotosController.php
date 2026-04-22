<?php
namespace yii\cherryii\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\web\Response;

use yii\cherryii\helpers\Image;
use yii\cherryii\components\Controller;
use yii\cherryii\models\Photo;
use yii\cherryii\behaviors\SortableController;

class PhotosController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],
            ],
            [
                'class' => SortableController::className(),
                'model' => Photo::className(),
            ]
        ];
    }

    public function actionUpload($class, $item_id)
    {
        $success = null;

        $photo = new Photo;
        $photo->class = $class;
        $photo->item_id = $item_id;
        $photo->image = UploadedFile::getInstance($photo, 'image');

        if($photo->image && $photo->validate(['image'])){
            $photo->image = Image::upload($photo->image, 'photos', Photo::PHOTO_MAX_WIDTH);

            if($photo->image){
                if($photo->save()){
                    $success = [
                        'message' => Yii::t('cherryii', 'Photo uploaded'),
                        'photo' => [
                            'id' => $photo->primaryKey,
                            'image' => $photo->image,
                            'thumb' => Image::thumb($photo->image, Photo::PHOTO_THUMB_WIDTH, Photo::PHOTO_THUMB_HEIGHT),
                            'description' => ''
                        ]
                    ];
                }
                else{
                    @unlink(Yii::getAlias('@webroot') . str_replace(Url::base(true), '', $photo->image));
                    $this->error = Yii::t('cherryii', 'Create error. {0}', $photo->formatErrors());
                }
            }
            else{
                $this->error = Yii::t('cherryii', 'File upload error. Check uploads folder for write permissions');
            }
        }
        else{
            $this->error = Yii::t('cherryii', 'File is incorrect');
        }

        return $this->formatResponse($success);
    }

    public function actionDescription($id)
    {
        if(($model = Photo::findOne($id)))
        {
            if(Yii::$app->request->post('description'))
            {
                $model->description = Yii::$app->request->post('description');
                if(!$model->update()) {
                    $this->error = Yii::t('cherryii', 'Update error. {0}', $model->formatErrors());
                }
            }
            else{
                $this->error = Yii::t('cherryii', 'Bad response');
            }
        }
        else{
            $this->error = Yii::t('cherryii', 'Not found');
        }

        return $this->formatResponse(Yii::t('cherryii', 'Photo description saved'));
    }

    public function actionImage($id)
    {
        $success = null;

        if(($photo = Photo::findOne($id)))
        {
            $oldImage = $photo->image;

            $photo->image = UploadedFile::getInstance($photo, 'image');

            if($photo->image && $photo->validate(['image'])){
                $photo->image = Image::upload($photo->image, 'photos', Photo::PHOTO_MAX_WIDTH);
                if($photo->image){
                    if($photo->save()){
                        @unlink(Yii::getAlias('@webroot').$oldImage);

                        $success = [
                            'message' => Yii::t('cherryii', 'Photo uploaded'),
                            'photo' => [
                                'image' => $photo->image,
                                'thumb' => Image::thumb($photo->image, Photo::PHOTO_THUMB_WIDTH, Photo::PHOTO_THUMB_HEIGHT)
                            ]
                        ];
                    }
                    else{
                        @unlink(Yii::getAlias('@webroot').$photo->image);

                        $this->error = Yii::t('cherryii', 'Update error. {0}', $photo->formatErrors());
                    }
                }
                else{
                    $this->error = Yii::t('cherryii', 'File upload error. Check uploads folder for write permissions');
                }
            }
            else{
                $this->error = Yii::t('cherryii', 'File is incorrect');
            }

        }
        else{
            $this->error =  Yii::t('cherryii', 'Not found');
        }

        return $this->formatResponse($success);
    }

    public function actionDelete($id)
    {
        if(($model = Photo::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('cherryii', 'Not found');
        }
        return $this->formatResponse(Yii::t('cherryii', 'Photo deleted'));
    }

    public function actionUp($id, $class, $item_id)
    {
        return $this->move($id, 'up', ['class' => $class, 'item_id' => $item_id]);
    }

    public function actionDown($id, $class, $item_id)
    {
        return $this->move($id, 'down', ['class' => $class, 'item_id' => $item_id]);
    }
}