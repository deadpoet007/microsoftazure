import java.awt.*;
import java.awt.event.*;
import java.awt.geom.*;
import javax.swing.*;
import javax.swing.border.*;
import java.util.*;
import java.io.*;
import java.lang.Math.*;
import java.util.StringTokenizer;

enum edit_states
{
    IDLE,
    ADD,
    NEW
}

class question implements Serializable
{
    String desc, op1, op2, op3, op4;
    int ans;
    int ansg;
    int x, y;
    boolean marked;
    Ellipse2D.Double mark;
    public question()
    {
        this.marked = false; 
        this.mark = new Ellipse2D.Double();
        this.desc = "";
        this.op1 = "";
        this.op2 = "";
        this.op3 = "";
        this.op4 = "";
        this.ans = 0;
        this.ansg = 0;
    }
    
    void setmark(double xx, double yy)
    {
        this.mark.setFrame(xx - 5, yy - 5, 10, 10);
    }
    
    boolean ismarked()
    {
        return marked;
    }
    
    void addDesc(String tdesc)
    {
        this.desc = tdesc;
    }
    
    void addop1(String top1)
    {
        this.op1 = top1;
    }
    
    void addop2(String top2)
    {
        this.op2 = top2;
    }
    
    void addop3(String top3)
    {
        this.op3 = top3;    
    }
    
    void addop4(String top4)
    {
        this.op4 = top4;
    }
    
    void addans(int tans)
    {
        this.ans = tans;
    }
    
    String getDesc()
    {
        return this.desc;
    }
    
    String getop1()
    {
        return this.op1;
    }
    
    String getop2()
    {
        return this.op2;
    }
    
    String getop3()
    {
        return this.op3;
    }
    
    String getop4()
    {
        return this.op4;
    }
    
    int getans()
    {
        return this.ans;
    }
    
    void putCoord(int xx, int yy)
    {
        this.x = xx;
        this.y = yy;
    }
    
    String getQues()
    {
        String q = "";
        q = "QUES: " + desc + "\n" + "1) " + op1 + "   " + "2) " + op2 + "\n" + "3) " + op3 + "  " + "4) " + op4;
        return q;
    }
}

class test implements Serializable
{
    Vector<question> list_of_ques;
    int quesCount;
    String id;
    public test()
    {
        this.quesCount = 0;
        this.list_of_ques = new Vector<question>(20,4);
    }
    
    void putid(String tid)
    {
        this.id = tid;
    }
    
    void add_ques(question tq)
    {
        list_of_ques.add(tq);
        quesCount++;
        System.out.println(tq.getQues());
    }
    
    question isthere(int xx, int yy)
    {
        question temp_ques;
        
        Iterator<question> itr = list_of_ques.iterator();
        while(itr.hasNext())
        {
            temp_ques = itr.next();
            if(temp_ques.mark.contains(xx, yy))
                return temp_ques;
        }
        
        return null;
    }
    
    double calc()
    {
        int num = 0;
        question temp_ques;
        
        Iterator<question> itr = list_of_ques.iterator();
        while(itr.hasNext())
        {
            temp_ques = itr.next();
            if(temp_ques.ans == temp_ques.ansg)
                num++;
        }
        
        return num/quesCount;
    }
    
}

public class geog implements ActionListener
{
    int user;
    JFrame main_frame;
    myJPanel drawing_panel;
    JLabel image_label;
    //ImageIcon ic;
    Image ic;
    JMenuBar jm;
    JMenu jmFile;
    JMenu ques;
    JButton jTakeTest;
    JButton submitTest;
    JMenuItem jmFileNew;
    JMenuItem jmFileImage;
    JMenuItem jmFileExit;
    JMenuItem jmFileSave;
    JMenuItem addques;
    JTextField test_id;
    test current_test;
    edit_states current_state;
    int XX, YY;
    
    public geog()
    {
        this.current_state = edit_states.IDLE;
        this.user = 0;
        main_frame = new JFrame();
        drawing_panel = new myJPanel();
        ic = new ImageIcon("xx.jpg").getImage();
        //ic = new Image("xx.jpg");
        //image_label = new JLabel(ic);
        //panel = new ImagePanel(new ImageIcon("xx.jpg").getImage());
        jm = new JMenuBar();
        test_id = new JTextField();
        
        jTakeTest = new JButton("take test");
        submitTest = new JButton("submit test");
        jmFile = new JMenu("FILE");
        jmFileNew = new JMenuItem("New");
        jmFileImage = new JMenuItem("Change Image");
        jmFileExit = new JMenuItem("Exit");
        jmFileSave = new JMenuItem("Save");
        ques = new JMenu("QUES");
        addques = new JMenuItem("Add New");
        jmFile.add(jmFileNew);
        jmFile.add(jmFileSave);
        jmFile.add(jmFileImage);
        jmFile.add(jmFileExit);
        ques.add(addques);
        jm.add(jmFile); 
        jm.add(ques);
        jm.add(jTakeTest);
        jm.add(submitTest);
        jm.add(test_id);
        jTakeTest.addActionListener(this);
        submitTest.addActionListener(this);
        jmFileNew.addActionListener(this);
        addques.addActionListener(this);
        jmFileSave.addActionListener(this);
        jmFileImage.addActionListener(this);
        jmFileExit.addActionListener(this);
        test_id.addActionListener(this);
        
        main_frame.setJMenuBar(jm);
        main_frame.add(drawing_panel);
        //drawing_panel.add(image_label);
        main_frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        main_frame.setSize(1366, 768);
        main_frame.setVisible(true);
    }
    
    public void actionPerformed(ActionEvent ae)
    {
        String value = ae.getActionCommand();
        switch(value)
        {
            case "New":
            if(user == 3)
            {
                int res = JOptionPane.showConfirmDialog((Component) null, "discard unsaved progress?","alert", JOptionPane.YES_NO_OPTION);
                if(res == 1)
                    break;
            }
            String[] buttons = {"teacher", "student", "cancel"};
            int rc = JOptionPane.showOptionDialog(null, "user type?", "Confirmation", JOptionPane.YES_NO_CANCEL_OPTION, JOptionPane.QUESTION_MESSAGE,  null, buttons, buttons[2]);
            if(rc == 0)
            {
                String pass = JOptionPane.showInputDialog("enter admin password");
                if(pass.equals("admin"))
                {
                    System.out.println("access granted");
                    user = 1;
                }
                else
                {
                    System.out.println("wrong password");
                    break;
                }
            }
            else if(rc == 1)
                user = 2;
            break;
            /*---------------------------------------------------------------------*/
            case "Save":
            if(user != 3)
                break;
            System.out.println("entered save case");
            try
            {
                FileOutputStream fileOut = new FileOutputStream( current_test.id + ".ser");
                ObjectOutputStream out = new ObjectOutputStream(fileOut);
                out.writeObject(current_test);
                out.close();
                fileOut.close();
            }
            catch(IOException e)
            {
                e.printStackTrace();
                System.out.println("---------------------------------unsuccessful-------------------------------open");
            }
            break;
            /*---------------------------------------------------------------------*/
            case "take test":
            if(user != 2)
                break;
            String tidd = JOptionPane.showInputDialog("enter test id");
            if(tidd != null)
            {
                try
                {
                    FileInputStream fileIn = new FileInputStream(tidd  + ".ser");
                    ObjectInputStream in = new ObjectInputStream(fileIn);
                    current_test = (test) in.readObject();
                    in.close();
                    fileIn.close();
                }
                catch(FileNotFoundException e)
                {
                    JOptionPane.showMessageDialog(null, "file not found");
                    break;
                }
                catch(IOException e)
                {
                    e.printStackTrace();
                    break;
                }
                catch(ClassNotFoundException e)
                {
                    e.printStackTrace();
                    break;
                }
                System.out.println("take test");
                drawing_panel.repaint();
            }
            break;
            /*---------------------------------------------------------------------*/
            case "Change Image":
            String img = JOptionPane.showInputDialog("enter image path");
            if(img == null || img.length() == 0)
                break;
            ic = new ImageIcon(img).getImage();
            drawing_panel.repaint();
            break;
            /*---------------------------------------------------------------------*/
            case "Add New":
            if(user == 1)
            {
                current_state = edit_states.NEW;
                System.out.println("NEW ac");
                break;
            }
            if(user != 3)
                break;
            System.out.println("trying to add ques  ADD ac");
            current_state = edit_states.ADD;
            break;
            /*---------------------------------------------------------------------*/
            case "submit test":
            if(user != 2)
                break;
            double num = current_test.calc()*100;
            JOptionPane.showMessageDialog(null, "you scored: " + num + " %");
            System.exit(0);
            break;
            /*---------------------------------------------------------------------*/
            case "Exit":
            if(user == 3)
            {
                int res = JOptionPane.showConfirmDialog((Component) null, "discard unsaved progress?","alert", JOptionPane.YES_NO_OPTION);
                if(res == 1)
                    break;
            }
            System.exit(0);
            break;
            /*---------------------------------------------------------------------*/
        }
    }
    
    class myJPanel extends JPanel implements MouseListener, MouseMotionListener
    {
        //popup_menu popup;
        
        public myJPanel()
        {
            addMouseListener(this);
            addMouseMotionListener(this);
            repaint();
            //this.popup = new popup_menu();
        }
        
        public void mouseClicked(MouseEvent me)
        {  
            int x = me.getX();
            int y = me.getY();
            //XX = me.getX();
            //YY = me.getY();
            //checkPopup(me);
            if(current_state == edit_states.ADD)
            {
                System.out.println("adding ques");
                question tempq = new question();
                String val = JOptionPane.showInputDialog("enter ques");
                if(val == null || val.length() == 0)
                    return;
                tempq.addDesc(val);
                val = JOptionPane.showInputDialog("enter option 1");
                if(val == null || val.length() == 0)
                    return;
                tempq.addop1(val);
                val = JOptionPane.showInputDialog("enter option 2");
                if(val == null || val.length() == 0)
                    return;
                tempq.addop2(val);
                val = JOptionPane.showInputDialog("enter option 3");
                if(val == null || val.length() == 0)
                    return;
                tempq.addop3(val);
                val = JOptionPane.showInputDialog("enter option 4");
                if(val == null || val.length() == 0)
                    return;
                tempq.addop4(val);
                val = JOptionPane.showInputDialog("enter answer");
                if(val == null || val.length() == 0)
                    return;
                try
                {
                    tempq.addans(Integer.parseInt(val));
                }
                catch(Exception e)
                {
                    return;
                }
                tempq.setmark((double)x, (double)y);
                current_test.add_ques(tempq);
                current_state = edit_states.IDLE;
                System.out.println("ADD");
                current_state = edit_states.IDLE;
            }
            else if(current_state == edit_states.NEW)
            {
                System.out.println("NEW");
                String tiddd = JOptionPane.showInputDialog("enter test id");
                current_test = new test();
                current_test.id = tiddd;
                user = 3;
                current_state = edit_states.IDLE;
            }
            else if(user == 2)
            {
                Iterator<question> itr = current_test.list_of_ques.iterator();
                question tempq;
                System.out.println("NEW Up");
                while(itr.hasNext())
                {
                    tempq = itr.next();
                    System.out.println("NEW Mid");
                    if(tempq.mark.contains(x, y) && !tempq.ismarked())
                    {
                        String res = tempq.getQues();
                        String valu = JOptionPane.showInputDialog(res);
                        try
                        {
                            tempq.ansg = Integer.parseInt(valu);
                        }
                        catch(Exception e)
                        {
                            return;
                        }
                        tempq.marked = true;
                        break;
                    }
                }
                System.out.println("NEW Down");
            }
            repaint();
        }

        public void mouseEntered(MouseEvent me)
        {
        }

        public void mouseExited(MouseEvent me)
        {       
        }

        public void mousePressed(MouseEvent me)
        {   
        }

        public void mouseReleased(MouseEvent me)
        {
        }    

        public void mouseDragged(MouseEvent me)
        {
        }    
        
        public void mouseMoved(MouseEvent me)
        {
        }    
        
        /*void checkPopup(MouseEvent me) 
        {
            if(me.isPopupTrigger()) 
            {
                popup.popup.show(myJPanel.this, XX, YY);
            }
        }*/
        
        public void paintComponent(Graphics g)
        {
            super.paintComponent(g);
            g.drawImage(ic, 35, 30, this);
            if(user == 0 || user == 1)
                return;
            Graphics2D gg = (Graphics2D) g;
            question tempq;
            Iterator<question> itr = current_test.list_of_ques.iterator();
            while(itr.hasNext())
            {
                tempq = itr.next();
                if(tempq.ismarked())
                    g.setColor(Color.RED);
                else
                    g.setColor(Color.GREEN);
                gg.draw(tempq.mark);
                gg.fill(tempq.mark);
                System.out.println("draw");
            }
            g.setColor(Color.BLACK);
        }
    }
    
    public static void main(String args[])
    {
        SwingUtilities.invokeLater(new Runnable()
                                   {
                                       public void run()
                                       {
                                           new geog();
                                       }
                                   }
                                  );
    }
}