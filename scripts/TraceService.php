<?php

class TraceService extends Service
{

    private $respond;
    private $tmpl;

    public function __construct()
    {
        parent::__construct();
        $this->respond = ResponseRegistery::getInstance();
        $this->tmpl = Template::getInstance( 'frontPage.tpl' );
    }

    public function show()
    {

        if( $this->input->getString( 'traceID' ) || $this->input->getString( 'traceCode' ) )
        {
            $this->traceID = $this->input->getString( 'traceID' );
            $this->traceCode = $this->input->getString( 'traceCode' );

            $this->tmpl->assign( 'hasResult', true );

            $req = array( );
            $req[ ] = $this->db->SimpleSelect( 'sh_requests', 'status,code', array( 'code' => $this->traceID ) )->fetch();
            $req[ ] = $this->db->SimpleSelect( 'sh_requests', 'status,code', array( 'code' => $this->traceCode ) )->fetch();


            $req[ ] = $this->db->SimpleSelect( 'fr_requests', 'status,code', array( 'code' => $this->traceID ) )->fetch();
            $req[ ] = $this->db->SimpleSelect( 'fr_requests', 'status,code', array( 'code' => $this->traceCode ) )->fetch();
            
            for($i=0;$i<4;++$i)
            {
                if($req[$i] != null)
                {
                    if($i < 2)
                     $this->tmpl->assign( 'shop_type', 'شخصی');
                    else
                     $this->tmpl->assign( 'shop_type', 'مشارکتی');
                    
                    $this->tmpl->assign('status',$req[$i]->status);
                    $this->tmpl->assign('trace_code', $req[$i]->code);
                    
                    fb($req);
                }
            }
        }

        $this->reponse->setTitle( 'لیست کالاها' );
        $this->tmpl->loadPage( 'traceShow' );
        $this->reponse->setTemplate( $this->tmpl );
    }

}

?>
