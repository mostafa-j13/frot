<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CardService
 *
 * @author mostafa
 */
class CardService extends Service
{

    public function add()
    {
        $item_id = $this->input->getInt( 'id' );
        $site_id = intval( ResponseRegistery::getInstance()->site_id );
        $sql = 'SELECT
		    item.*
		  FROM sh_items as item
		  JOIN sh_subgroups_items as si
		    ON(si.item_id=item.id)
		  JOIN sh_subgroups as sub
		    ON(sub.id=si.subgroup_id)
		  JOIn sh_groups as gr
		    ON(gr.id=sub.group_id)
		  WHERE 
		    item.id=' . $item_id . ' and
		    gr.site_id=' . $site_id;
        fb( $sql );
        $data = $this->db->query( $sql )->fetch();
        if( !$data->id )
        {
            throw new Exception( "hoooooooooooooy", '100' );
        }
        $card = $this->getCard();
        $card[ $site_id ]->items[ $data->id ] = $data;
        $this->saveCard( $card );
        fb( $_SESSION );
        $this->reponse->redirect( $_SERVER[ 'HTTP_REFERER' ] );
    }

    private function getCard()
    {
        $card = Session::getInstance()->card;
        if( !is_array( $card ) )
        {
            $card = array( );
        }

        return $card;
    }

    private function saveCard( $card )
    {
        Session::getInstance()->card = $card;
    }

    public function remove()
    {
        $id = $this->input->getInt( 'id' );
        $site_id = intval( ResponseRegistery::getInstance()->site_id );
        $card = $this->getCard();
        unset( $card[ $site_id ]->items[ $id ] );
        $this->saveCard( $card );
        $this->reponse->redirect( $_SERVER[ 'HTTP_REFERER' ] );
    }

    public function clear()
    {
        $site_id = intval( ResponseRegistery::getInstance()->site_id );
        $card = $this->getCard();
        unset( $card[ $site_id ] );
        $this->saveCard( $card );
        $this->reponse->redirect( $_SERVER[ 'HTTP_REFERER' ] );
    }

    public function checkout()
    {
        $tmpl = Template::getInstance( 'checkout.tpl' );
        $site_id = intval( ResponseRegistery::getInstance()->site_id );
        $card = $this->getCard();
        fb( $card );
        $tmpl->assign( 'items', $card[ $site_id ]->items );
        
        $this->reponse->setTitle( 'ثبت سفارش' );
        $this->reponse->setTemplate( $tmpl );
    }

    public function save()
    {
        $data = $this->input->get( 'post' );
        $data[ 'code' ] = $this->genCode();
        $site_id = intval( ResponseRegistery::getInstance()->site_id );
        $this->db->StoreObject( "sh_requests", $data );

        $tmp->request_id = $this->db->insert_id();

        $card = $this->getCard();
        foreach( $card[ $site_id ]->items as $item )
        {
            $tmp->item_id = $item->id;
            $this->db->StoreObject( "sh_items_requests", $tmp );
        }
        $tmpl = Template::getInstance( 'finish_checkout.tpl' );
        $tmpl->assign( 'code', $data[ 'code' ] );
        $this->reponse->setTemplate( $tmpl );
        $this->reponse->setTitle( 'اتمام خرید' );
        unset( $card[ $site_id ] );
        $this->saveCard( $card );
    }

    private function genCode()
    {
        return rand( 1000, 9999 ) . '-' . rand( 1000, 9999 ) . '-' . rand( 1000, 9999 );
    }

    public function frotelAdd()
    {
        fb( 'sssssssssssss' );
        $item_id = $this->input->getInt( 'id' );
        $site_id = intval( ResponseRegistery::getInstance()->site_id );
        $sql = 'SELECT
		    item.*
		  FROM fr_items as item
		  JOIN fr_subgroups_items as si
		    ON(si.item_id=item.id)
		  JOIN fr_subgroups as sub
		    ON(sub.id=si.subgroup_id)
		  JOIn fr_groups as gr
		    ON(gr.id=sub.group_id)
		  WHERE
		    item.id=' . $item_id;

        $data = $this->db->query( $sql )->fetch();
        if( !$data->id )
        {
            throw new Exception( "hoooooooooooooy", '100' );
        }
        $card = $this->getFrotelCard();
        $card[ $site_id ]->items[ $data->id ] = $data;
        $this->saveFrotelCard( $card );
        fb( $_SESSION );
        $this->reponse->redirect( $_SERVER[ 'HTTP_REFERER' ] );
    }

    private function getFrotelCard()
    {
        $card = Session::getInstance()->frotelCard;
        if( !is_array( $card ) )
        {
            $card = array( );
        }

        return $card;
    }

    private function saveFrotelCard( $card )
    {
        Session::getInstance()->frotelCard = $card;
    }

    public function frotelRemove()
    {
        $id = $this->input->getInt( 'id' );
        $site_id = intval( ResponseRegistery::getInstance()->site_id );
        $card = $this->getFrotelCard();
        unset( $card[ $site_id ]->items[ $id ] );
        $this->saveFrotelCard( $card );
        $this->reponse->redirect( $_SERVER[ 'HTTP_REFERER' ] );
    }

    public function frotelClear()
    {
        $site_id = intval( ResponseRegistery::getInstance()->site_id );
        $card = $this->getFrotelCard();
        unset( $card[ $site_id ] );
        $this->saveFrotelCard( $card );
        $this->reponse->redirect( $_SERVER[ 'HTTP_REFERER' ] );
    }

    public function FrotelCheckout()
    {

        $tmpl = Template::getInstance( 'checkout.tpl' );
        $site_id = intval( ResponseRegistery::getInstance()->site_id );
        $card = $this->getFrotelCard();
        fb( $card );
        $tmpl->assign( 'items', $card[ $site_id ]->items );
        $this->reponse->setTemplate( $tmpl );
        $this->reponse->setTitle( 'ثبت سفارش' );
    }

    public function FrotelSave()
    {
        $data = $this->input->get( 'post' );
        $data[ 'code' ] = $this->genCode();
        $site_id = intval( ResponseRegistery::getInstance()->site_id );
        $this->db->StoreObject( "sh_requests", $data );

        $tmp->request_id = $this->db->insert_id();

        $card = $this->getFrotelCard();
        foreach( $card[ $site_id ]->items as $item )
        {
            $tmp->item_id = $item->id;
            $this->db->StoreObject( "sh_items_requests", $tmp );
        }
        $tmpl = Template::getInstance( 'finish_checkout.tpl' );
        $tmpl->assign( 'code', $data[ 'code' ] );
        $this->reponse->setTemplate( $tmpl );
        $this->reponse->setTitle( 'اتمام خرید' );
        unset( $card[ $site_id ] );
        $this->saveFrotelCard( $card );
    }

}

?>
