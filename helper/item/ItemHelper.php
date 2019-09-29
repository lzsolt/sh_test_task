<?php

namespace app\helper\item;

class ItemHelper
{
    private $jsonItemData;


    private function getArtist(): string
    {
        return $this->jsonItemData->imageCredit->artist;
    }

    private function getImageUrl(): string
    {
        return $this->jsonItemData->imageUrl;
    }

    private function getPrice(): float
    {
        return (float) $this->jsonItemData->price;
    }

    private function getName(): string
    {
        return $this->jsonItemData->name;
    }

    private function getDescription(): string
    {
        return $this->jsonItemData->description;
    }

    private function getSlug(): string
    {
        return $this->jsonItemData->slug;
    }

    private function getAdded(): string
    {
        $date = new \DateTime();
        return \DateTime::createFromFormat('U.u', $this->jsonItemData->added / 1000)->format('c');
    }

    private function getManufacturer(): string
    {
        return $this->jsonItemData->manufacturer;
    }

    private function getItemType(): string
    {
        return $this->jsonItemData->itemType;
    }

    public function generateModelArray($jsonItemData): array
    {
        $this->jsonItemData = json_decode($jsonItemData);

        return [
            'artist' => $this->getArtist(),
            'image_url' => $this->getImageUrl(),
            'price' => $this->getPrice(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'slug' => $this->getSlug(),
            'added' => $this->getAdded(),
            'manufacturer' => $this->getManufacturer(),
            'item_type' => $this->getItemType(),
        ];
    }
}